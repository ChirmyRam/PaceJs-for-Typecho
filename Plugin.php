<?php
/**
 * 页面加载进度条插件 for Typecho
 *
 * @package 页面加载进度条插件
 * @author 没那么简单
 * @version 1.0.0
 * @link http://nsimple.top
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class PaceJs_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('PaceJs')->render = array('PaceJs_Plugin', 'render');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 进度条主题配置 */
        $colors = array(
            'black'  => '黑色',
            'blue'   => '蓝色',
            'green'  => '绿色',
            'orange' => '橙色',
            'pink'   => '粉红色',
            'purple' => '紫色',
            'red'    => '红色',
            'silver' => '银色',
            'white'  => '白色',
            'yellow' => '黄色'
        );

        $types = array(
            'barber-shop'      => '理发店型',
            'big-counter'      => '大字号数字型',
            'bounce'           => '萌萌哒跳跃型',
            'center-atom'      => '旋转桃花型',
            'center-circle'    => '翻转圆圈型',
            'center-radar'     => '雷达扫描型',
            'center-simple'    => '居中常规型',
            'corner-indicator' => '角指示器型',
            'fill-left'        => '左侧填充型',
            'flash'            => 'flash控件型',
            'flat-top'         => '平直呆板型',
            'loading-bar'      => '缓存加载型',
            'minimal'          => '简洁小巧型',
            'mac-osx'          => 'Mac系统型',
            'material'         => '材料物质型'
        );
        $paceJsColor = new Typecho_Widget_Helper_Form_Element_Select('paceJsColor', $colors, 'blue', _t('进度条颜色'));
        $paceJsTheme = new Typecho_Widget_Helper_Form_Element_Select('paceJsTheme', $types, 'flash', _t('进度条主题'));
        $form->addInput($paceJsColor);
        $form->addInput($paceJsTheme);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
        $config = Typecho_Widget::widget('Widget_Options')->plugin('PaceJs');
        $pluginUrl = Helper::options()->pluginUrl . '/PaceJs';
        $themeUrl = $pluginUrl . '/themes/' . $config->paceJsColor . '/pace-theme-' . $config->paceJsTheme . '.css';
        echo '<link href="' . $themeUrl . '" rel="stylesheet" />';
        echo <<<EOT
            <script> paceOptions = { elements: {selectors: ['#footer']}};</script>
            <script src="{$pluginUrl}/pace.min.js"></script>            
EOT;
    }
}
