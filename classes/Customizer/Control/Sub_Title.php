<?php
namespace SWELL_Theme\Customizer\Control;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 大タイトル出力用
 */
class Sub_Title extends \WP_Customize_Control {

	public $classname = ''; //追加したメンバ変数

	// 出力するコンテンツ
	public function render_content() {
		$return = '';
		if ( isset( $this->label ) ) {
			$return .= '<span class="customize-control-title -sub">' . esc_html( $this->label ) . '</span>';
		}
		if ( isset( $this->description ) ) {
			$return .= '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}

		echo wp_kses( $return, \SWELL_Theme::$allowed_text_html );
	}

	protected function render() {
		$id    = 'customize-control-' . str_replace( [ '[', ']' ], [ '-', '' ], $this->id );
		$class = 'customize-control customize-control-' . $this->type;

		if ( isset( $this->classname ) ) {
			$class .= ' ' . $this->classname; //追加した処理
		}

		printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
		$this->render_content();
		echo '</li>';
	}
}
