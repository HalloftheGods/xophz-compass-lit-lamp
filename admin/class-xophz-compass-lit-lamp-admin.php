<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Xophz_Compass_Lit_Lamp
 * @subpackage Xophz_Compass_Lit_Lamp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Xophz_Compass_Lit_Lamp
 * @subpackage Xophz_Compass_Lit_Lamp/admin
 * @author     Your Name <email@example.com>
 */
class Xophz_Compass_Lit_Lamp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Xophz_Compass_Lit_Lamp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xophz_Compass_Lit_Lamp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/xophz-compass-lit-lamp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Xophz_Compass_Lit_Lamp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xophz_Compass_Lit_Lamp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/xophz-compass-lit-lamp-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add menu item 
	 *
	 * @since    1.0.0
	 */
	public function addToMenu(){
        Xophz_Compass::add_submenu($this->plugin_name);
	}

	/**
	 * Get system information for the LAMP stack
	 *
	 * @since    1.0.0
	 */
	public function getSystemInfo(){
		$system_info = array(
			'os'        => $this->getOsInfo(),
			'webserver' => $this->getWebServerInfo(),
			'database'  => $this->getDatabaseInfo(),
			'php'       => $this->getPhpInfo()
		);

		Xophz_Compass::output_json(array(
			'success' => true,
			'data'    => $system_info
		));
	}

	/**
	 * Get operating system information
	 *
	 * @since    1.0.0
	 * @return   array
	 */
	private function getOsInfo() {
		$os_name = php_uname('s');
		$os_release = php_uname('r');
		$os_version = php_uname('v');
		$machine = php_uname('m');
		
		// Determine OS type for icon/display purposes
		$os_type = 'unknown';
		if (stripos($os_name, 'linux') !== false) {
			$os_type = 'linux';
		} elseif (stripos($os_name, 'darwin') !== false || stripos($os_name, 'mac') !== false) {
			$os_type = 'macos';
		} elseif (stripos($os_name, 'windows') !== false || stripos($os_name, 'win') !== false) {
			$os_type = 'windows';
		} elseif (stripos($os_name, 'bsd') !== false) {
			$os_type = 'bsd';
		}

		// Try to get distribution info on Linux
		$distro = '';
		if ($os_type === 'linux' && is_readable('/etc/os-release')) {
			$os_release_content = file_get_contents('/etc/os-release');
			if (preg_match('/^PRETTY_NAME="?([^"\n]+)"?/m', $os_release_content, $matches)) {
				$distro = $matches[1];
			}
		}

		return array(
			'name'         => $os_name,
			'type'         => $os_type,
			'release'      => $os_release,
			'version'      => $os_version,
			'architecture' => $machine,
			'distro'       => $distro,
			'hostname'     => php_uname('n')
		);
	}

	/**
	 * Get web server information
	 *
	 * @since    1.0.0
	 * @return   array
	 */
	private function getWebServerInfo() {
		$server_software = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown';
		
		// Parse server software to get name and version
		$server_name = 'Unknown';
		$server_version = '';
		$server_type = 'unknown';
		
		if (preg_match('/^([^\s\/]+)(?:\/(\S+))?/', $server_software, $matches)) {
			$server_name = $matches[1];
			$server_version = isset($matches[2]) ? $matches[2] : '';
		}
		
		// Determine server type for icon/display purposes
		if (stripos($server_name, 'apache') !== false) {
			$server_type = 'apache';
		} elseif (stripos($server_name, 'nginx') !== false) {
			$server_type = 'nginx';
		} elseif (stripos($server_name, 'litespeed') !== false) {
			$server_type = 'litespeed';
		} elseif (stripos($server_name, 'iis') !== false || stripos($server_name, 'microsoft') !== false) {
			$server_type = 'iis';
		} elseif (stripos($server_name, 'caddy') !== false) {
			$server_type = 'caddy';
		}

		// Get loaded Apache modules if available
		$modules = array();
		if ($server_type === 'apache' && function_exists('apache_get_modules')) {
			$modules = apache_get_modules();
		}

		return array(
			'software' => $server_software,
			'name'     => $server_name,
			'type'     => $server_type,
			'version'  => $server_version,
			'modules'  => $modules,
			'protocol' => isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : '',
			'port'     => isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : ''
		);
	}

	/**
	 * Get database information
	 *
	 * @since    1.0.0
	 * @return   array
	 */
	private function getDatabaseInfo() {
		global $wpdb;
		
		$db_version = $wpdb->db_version();
		$db_server_info = $wpdb->db_server_info();
		
		// Determine database type
		$db_type = 'mysql';
		if (stripos($db_server_info, 'mariadb') !== false) {
			$db_type = 'mariadb';
		} elseif (stripos($db_server_info, 'percona') !== false) {
			$db_type = 'percona';
		}

		// Get database size
		$db_size = 0;
		$table_count = 0;
		$tables = $wpdb->get_results("
			SELECT table_name, 
			       ROUND((data_length + index_length) / 1024 / 1024, 2) AS size_mb
			FROM information_schema.tables 
			WHERE table_schema = '" . DB_NAME . "'
		");
		
		if ($tables) {
			$table_count = count($tables);
			foreach ($tables as $table) {
				$db_size += floatval($table->size_mb);
			}
		}

		return array(
			'type'        => $db_type,
			'version'     => $db_version,
			'server_info' => $db_server_info,
			'host'        => DB_HOST,
			'name'        => DB_NAME,
			'user'        => DB_USER,
			'charset'     => DB_CHARSET,
			'collate'     => DB_COLLATE,
			'prefix'      => $wpdb->prefix,
			'table_count' => $table_count,
			'size_mb'     => round($db_size, 2)
		);
	}

	/**
	 * Get PHP information
	 *
	 * @since    1.0.0
	 * @return   array
	 */
	private function getPhpInfo() {
		// Get key PHP extensions
		$loaded_extensions = get_loaded_extensions();
		$key_extensions = array_intersect($loaded_extensions, array(
			'curl', 'gd', 'imagick', 'mbstring', 'openssl', 'json', 
			'xml', 'zip', 'mysqli', 'pdo_mysql', 'redis', 'memcached',
			'intl', 'soap', 'opcache', 'xdebug'
		));

		// Get memory limit and convert to MB
		$memory_limit = ini_get('memory_limit');
		$memory_limit_bytes = wp_convert_hr_to_bytes($memory_limit);
		$memory_limit_mb = round($memory_limit_bytes / 1024 / 1024);

		// Get max execution time
		$max_execution_time = ini_get('max_execution_time');

		// Get upload max filesize
		$upload_max_filesize = ini_get('upload_max_filesize');
		$post_max_size = ini_get('post_max_size');

		// Check if OPcache is enabled
		$opcache_enabled = function_exists('opcache_get_status') && opcache_get_status() !== false;

		return array(
			'version'            => phpversion(),
			'sapi'               => php_sapi_name(),
			'memory_limit'       => $memory_limit,
			'memory_limit_mb'    => $memory_limit_mb,
			'max_execution_time' => $max_execution_time,
			'upload_max_size'    => $upload_max_filesize,
			'post_max_size'      => $post_max_size,
			'extensions'         => array_values($key_extensions),
			'extension_count'    => count($loaded_extensions),
			'opcache_enabled'    => $opcache_enabled,
			'zend_version'       => zend_version(),
			'display_errors'     => ini_get('display_errors'),
			'error_reporting'    => error_reporting()
		);
	}

	/**
	 * Get WordPress information
	 *
	 * @since    1.0.0
	 */
	public function getWpInfo(){
		global $wp_version;

		// Get active theme
		$theme = wp_get_theme();

		// Get debug constants
		$debug_mode = defined('WP_DEBUG') && WP_DEBUG;
		$debug_log = defined('WP_DEBUG_LOG') && WP_DEBUG_LOG;
		$debug_display = defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY;

		// Get memory limit from WP
		$wp_memory_limit = defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : 'Not set';
		$wp_max_memory_limit = defined('WP_MAX_MEMORY_LIMIT') ? WP_MAX_MEMORY_LIMIT : 'Not set';

		// Check multisite
		$is_multisite = is_multisite();

		// REST API
		$rest_url = rest_url();

		// Get WordPress environment
		$environment = wp_get_environment_type();

		// Get site URL info
		$site_url = site_url();
		$home_url = home_url();

		// Get admin email
		$admin_email = get_option('admin_email');

		// Get timezone
		$timezone = wp_timezone_string();

		// Get language
		$language = get_locale();

		// Check if auto updates are enabled
		$auto_update_core = defined('WP_AUTO_UPDATE_CORE') ? WP_AUTO_UPDATE_CORE : 'Not set';

		// Get permalink structure
		$permalink_structure = get_option('permalink_structure') ?: 'Plain';

		Xophz_Compass::output_json(array(
			'success' => true,
			'data'    => array(
				'version'             => $wp_version,
				'environment'         => $environment,
				'debug_mode'          => $debug_mode,
				'debug_log'           => $debug_log,
				'debug_display'       => $debug_display,
				'wp_memory_limit'     => $wp_memory_limit,
				'wp_max_memory_limit' => $wp_max_memory_limit,
				'is_multisite'        => $is_multisite,
				'rest_url'            => $rest_url,
				'site_url'            => $site_url,
				'home_url'            => $home_url,
				'admin_email'         => $admin_email,
				'timezone'            => $timezone,
				'language'            => $language,
				'auto_update_core'    => $auto_update_core,
				'permalink_structure' => $permalink_structure,
				'theme'               => array(
					'name'    => $theme->get('Name'),
					'version' => $theme->get('Version'),
					'author'  => $theme->get('Author'),
					'parent'  => $theme->parent() ? $theme->parent()->get('Name') : null
				)
			)
		));
	}

	/**
	 * Get log file contents
	 *
	 * @since    1.0.0
	 */
	public function getLogs(){
		$args = Xophz_Compass::get_input_json();
		$lines = isset($args->lines) ? intval($args->lines) : 100;
		$search = isset($args->search) ? $args->search : '';
		$level = isset($args->level) ? $args->level : 'all';

		$log_file = WP_CONTENT_DIR . '/debug.log';
		$logs = array();
		$log_exists = file_exists($log_file);
		$log_size = 0;

		if ($log_exists && is_readable($log_file)) {
			$log_size = filesize($log_file);
			
			// Read last N lines efficiently
			$file = new SplFileObject($log_file, 'r');
			$file->seek(PHP_INT_MAX);
			$total_lines = $file->key();
			
			$start_line = max(0, $total_lines - $lines);
			$file->seek($start_line);

			while (!$file->eof()) {
				$line = $file->fgets();
				if (empty(trim($line))) continue;

				// Parse log entry
				$entry = array(
					'raw'   => $line,
					'level' => 'info',
					'time'  => null
				);

				// Try to extract timestamp
				if (preg_match('/^\[(\d{2}-\w{3}-\d{4}\s+\d{2}:\d{2}:\d{2})\s+\w+\]/', $line, $matches)) {
					$entry['time'] = $matches[1];
				}

				// Determine log level
				if (stripos($line, 'fatal') !== false) {
					$entry['level'] = 'fatal';
				} elseif (stripos($line, 'error') !== false) {
					$entry['level'] = 'error';
				} elseif (stripos($line, 'warning') !== false) {
					$entry['level'] = 'warning';
				} elseif (stripos($line, 'notice') !== false || stripos($line, 'deprecated') !== false) {
					$entry['level'] = 'notice';
				}

				// Filter by level
				if ($level !== 'all' && $entry['level'] !== $level) {
					continue;
				}

				// Filter by search term
				if (!empty($search) && stripos($line, $search) === false) {
					continue;
				}

				$logs[] = $entry;
			}

			$logs = array_reverse($logs);
		}

		Xophz_Compass::output_json(array(
			'success'     => true,
			'data'        => array(
				'exists'      => $log_exists,
				'path'        => $log_file,
				'size'        => $log_size,
				'size_human'  => size_format($log_size),
				'entries'     => $logs,
				'total_count' => count($logs)
			)
		));
	}

	/**
	 * Get file/directory sizes
	 *
	 * @since    1.0.0
	 */
	public function getFiles(){
		$directories = array(
			'wp-content'   => WP_CONTENT_DIR,
			'uploads'      => wp_upload_dir()['basedir'],
			'plugins'      => WP_PLUGIN_DIR,
			'themes'       => get_theme_root(),
			'mu-plugins'   => WPMU_PLUGIN_DIR,
			'cache'        => WP_CONTENT_DIR . '/cache',
			'upgrade'      => WP_CONTENT_DIR . '/upgrade',
			'languages'    => WP_CONTENT_DIR . '/languages'
		);

		$results = array();
		$total_size = 0;

		foreach ($directories as $name => $path) {
			$size = 0;
			$files = 0;
			$exists = is_dir($path);

			if ($exists) {
				$size = $this->getDirSize($path);
				$files = $this->getFileCount($path);
			}

			$results[$name] = array(
				'path'       => $path,
				'exists'     => $exists,
				'size'       => $size,
				'size_human' => size_format($size),
				'files'      => $files
			);

			if ($name !== 'wp-content') {
				$total_size += $size;
			}
		}

		// Get disk free space
		$disk_free = disk_free_space(ABSPATH);
		$disk_total = disk_total_space(ABSPATH);

		Xophz_Compass::output_json(array(
			'success' => true,
			'data'    => array(
				'directories'  => $results,
				'disk_free'    => $disk_free,
				'disk_total'   => $disk_total,
				'disk_used'    => $disk_total - $disk_free,
				'disk_percent' => round((($disk_total - $disk_free) / $disk_total) * 100, 1)
			)
		));
	}

	/**
	 * Get directory size recursively
	 */
	private function getDirSize($path) {
		$size = 0;
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST
		);
		foreach ($iterator as $file) {
			if ($file->isFile()) {
				$size += $file->getSize();
			}
		}
		return $size;
	}

	/**
	 * Get file count in directory
	 */
	private function getFileCount($path) {
		$count = 0;
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
		);
		foreach ($iterator as $file) {
			if ($file->isFile()) {
				$count++;
			}
		}
		return $count;
	}

	/**
	 * Get WP-Cron scheduled jobs
	 *
	 * @since    1.0.0
	 */
	public function getCronJobs(){
		$crons = _get_cron_array();
		$schedules = wp_get_schedules();
		$jobs = array();

		if (is_array($crons)) {
			foreach ($crons as $timestamp => $cronhooks) {
				foreach ($cronhooks as $hook => $keys) {
					foreach ($keys as $key => $data) {
						$schedule_name = isset($data['schedule']) ? $data['schedule'] : 'Once';
						$interval = '';

						if ($schedule_name !== 'Once' && isset($schedules[$schedule_name])) {
							$interval = $schedules[$schedule_name]['display'];
						}

						$jobs[] = array(
							'hook'      => $hook,
							'timestamp' => $timestamp,
							'next_run'  => date('Y-m-d H:i:s', $timestamp),
							'schedule'  => $schedule_name,
							'interval'  => $interval,
							'args'      => $data['args']
						);
					}
				}
			}
		}

		// Sort by next run time
		usort($jobs, function($a, $b) {
			return $a['timestamp'] - $b['timestamp'];
		});

		// Get cron status
		$cron_disabled = defined('DISABLE_WP_CRON') && DISABLE_WP_CRON;
		$alternate_cron = defined('ALTERNATE_WP_CRON') && ALTERNATE_WP_CRON;

		Xophz_Compass::output_json(array(
			'success' => true,
			'data'    => array(
				'jobs'           => $jobs,
				'total_count'    => count($jobs),
				'schedules'      => $schedules,
				'cron_disabled'  => $cron_disabled,
				'alternate_cron' => $alternate_cron
			)
		));
	}

}
