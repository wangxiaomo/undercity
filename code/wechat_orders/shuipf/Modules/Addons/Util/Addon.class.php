<?php

/**
 * 插件抽象类
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
abstract class Addon {

    //视图实例对象
    protected $view = null;
    //插件名称
    public $addonName = NULL;
    //插件配置文件
    public $configFile = NULL;
    //插件目录
    public $addonPath = NULL;
    // 使用的模板引擎 每个行为可以单独配置不受系统影响
    protected $template = 'Think';

    /**
     * 模板输出变量
     * @var tVar
     * @access protected
     */
    protected $tVar = array();

    /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    final public function __construct() {
        //获取插件名称
        $this->addonName = $this->getAddonName();
        //插件目录
        $this->addonPath = D('Addons/Addons')->getAddonsPath() . $this->addonName . '/';
        //插件配置文件
        if (is_file($this->addonPath . 'Config.php')) {
            $this->configFile = $this->addonPath . 'Config.php';
        }
        //插件初始化
        if (method_exists($this, '_initialize'))
            $this->_initialize();
    }

    /**
     * 获取插件名称
     * @return type
     */
    final public function getAddonName() {
        $class = get_class($this);
        return substr($class, 0, strrpos($class, 'Addon'));
    }

    /**
     * 获取插件配置
     * @staticvar array $_config
     * @param type $name
     * @return type
     */
    final public function getAddonConfig($name = NULL) {
        static $_config = array();
        if (empty($name)) {
            $name = $this->addonName;
        }
        //检查是否已经存在
        if (isset($_config[$name])) {
            return $_config[$name];
        }
        //查询条件
        $where = array(
            'name' => $name,
            'status' => 1,
        );
        $config = M('Addons')->where($where)->getField('config');
        if ($config) {
            //反序列化
            $config = unserialize($config);
        }
        //直接取插件目录下的Config.php中的配置
        if (empty($config)) {
            $fileConfig = include $this->configFile;
            foreach ($fileConfig as $key => $value) {
                $config[$key] = $value['value'];
            }
        }
        $_config[$name] = $config;
        return $config;
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return Action
     */
    public function assign($name, $value = '') {
        if (is_array($name)) {
            $this->tVar = array_merge($this->tVar, $name);
        } else {
            $this->tVar[$name] = $value;
        }
    }

    /**
     * 渲染模板输出 供render方法内部调用
     * @access public
     * @param string $templateFile  模板文件
     * @return string
     */
    protected function renderFile($templateFile = '') {
        if (empty($templateFile)) {
            //如果没有填写，尝试直接以当前插件名称
            $templateFile = $this->addonPath . 'Tpl/Behavior/' . $this->addonName . C('TMPL_TEMPLATE_SUFFIX');
        } else {
            $templateFile = $this->addonPath . 'Tpl/Behavior/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
        }
        //检查模板
        if (!is_file($templateFile)) {
            if (APP_DEBUG) {
                $log = '插件模板:[' . $templateFile . ']不存在！';
                throw_exception($log);
            }
        }
        ob_start();
        ob_implicit_flush(0);
        $template = strtolower($this->template ? $this->template : (C('TMPL_ENGINE_TYPE') ? C('TMPL_ENGINE_TYPE') : 'php'));
        if ('php' == $template) {
            // 使用PHP模板
            if (!empty($this->tVar))
                extract($this->tVar, EXTR_OVERWRITE);
            // 直接载入PHP模板
            include $templateFile;
        }elseif ('think' == $template) { // 采用Think模板引擎
            if ($this->checkCache($templateFile)) { // 缓存有效
                // 分解变量并载入模板缓存
                extract($this->tVar, EXTR_OVERWRITE);
                //载入模版缓存文件
                include C('CACHE_PATH') . md5($templateFile) . C('TMPL_CACHFILE_SUFFIX');
            } else {
                //如果取不到相关配置，尝试加载下ParseTemplate行为
                if (!C('TMPL_L_DELIM')) {
                    B('ParseTemplate');
                }
                $tpl = Think::instance('ThinkTemplate');
                // 编译并加载模板文件
                $tpl->fetch($templateFile, $this->tVar);
            }
        } else {
            $class = 'Template' . ucwords($template);
            if (is_file(CORE_PATH . 'Driver/Template/' . $class . '.class.php')) {
                // 内置驱动
                $path = CORE_PATH;
            } else { // 扩展驱动
                $path = EXTEND_PATH;
            }
            require_cache($path . 'Driver/Template/' . $class . '.class.php');
            $tpl = new $class;
            $tpl->fetch($templateFile, $this->tVar);
        }
        $content = ob_get_clean();
        return $content;
    }

    /**
     * 检查缓存文件是否有效
     * 如果无效则需要重新编译
     * @access public
     * @param string $tmplTemplateFile  模板文件名
     * @return boolen
     */
    protected function checkCache($tmplTemplateFile) {
        if (!C('TMPL_CACHE_ON')) // 优先对配置设定检测
            return false;
        $tmplCacheFile = C('CACHE_PATH') . md5($tmplTemplateFile) . C('TMPL_CACHFILE_SUFFIX');
        if (!is_file($tmplCacheFile)) {
            return false;
        } elseif (filemtime($tmplTemplateFile) > filemtime($tmplCacheFile)) {
            // 模板文件如果有更新则缓存需要更新
            return false;
        } elseif (C('TMPL_CACHE_TIME') != 0 && time() > filemtime($tmplCacheFile) + C('TMPL_CACHE_TIME')) {
            // 缓存是否在有效期
            return false;
        }
        // 缓存有效
        return true;
    }

    /**
     * 模板显示 调用内置的模板引擎显示方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @return void
     */
    protected function display($templateFile = '') {
        echo $this->renderFile($templateFile);
    }

    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();
}