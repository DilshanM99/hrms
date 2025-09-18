<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_error('This controller can only be accessed via CLI', 403);
        }
        $this->load->library('migration');
    }

    public function index()
    {
        echo "Migration path: " . $this->migration->config->item('migration_path') . "\n";
        echo "Migration files: " . print_r(glob($this->migration->config->item('migration_path') . '*.php'), TRUE) . "\n";
        echo "Target version: " . $this->migration->config->item('migration_version') . "\n";
        if ($this->migration->current() === FALSE) {
            echo "Migration error: " . $this->migration->error_string() . "\n";
            show_error($this->migration->error_string());
        } else {
            echo "Migration completed successfully.\n";
        }
    }

    public function version($version)
    {
        echo "Running migration version: $version\n";
        if ($this->migration->version($version) === FALSE) {
            echo "Migration error: " . $this->migration->error_string() . "\n";
            show_error($this->migration->error_string());
        } else {
            echo "Migrated to version $version successfully.\n";
        }
    }
}