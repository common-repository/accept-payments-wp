<?php

namespace AcceptPaymentsWPInc\Core\Admin;

class AcceptPaymentsWPSettingsApi
{

	// for admin pages
	public $admin_sub_pages = array();

	// for custom fields
	public $settings = array();
	public $sections = array();
	public $fields = array();

	public function register()
	{
		if ( ! empty($this->admin_sub_pages) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		}

		if ( !empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'registerCustomFields' ) );
		}
	}

	public function addSubPages( array $pages )
	{
		$this->admin_sub_pages = array_merge( $this->admin_sub_pages, $pages );

		return $this;
	}

	public function addAdminMenu()
	{

		foreach ( $this->admin_sub_pages as $page ) {
			add_submenu_page(
			    			$page['parent_slug'],
                $page['page_title'],
                $page['menu_title'],
                $page['capability'],
                $page['menu_slug'],
                $page['callback']
            );
		}
	}

	public function setSettings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}

	public function setSections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}

	public function setFields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}

	public function registerCustomFields()
	{
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting(
			    $setting["option_group"],
                $setting["option_name"],
                ( isset( $setting["callback"] ) ? $setting["callback"] : '' )
            );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section(
			    $section["id"],
                $section["title"],
                ( isset( $section["callback"] ) ? $section["callback"] : '' ),
                $section["page"]
            );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field(
			    $field["id"],
                $field["title"],
                ( isset( $field["callback"] ) ? $field["callback"] : '' ),
                $field["page"],
                $field["section"],
                ( isset( $field["args"] ) ? $field["args"] : '' )
            );
		}
	}
}
