<?php

namespace App\Logging;
use App\Helpers\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class AuditLoggingHandler extends AbstractProcessingHandler
{

    protected $table;
    protected $connection;

    public function __construct($level = Logger::INFO, $bubble = true)
    {
        $this->table = 'audit.log';
        parent::__construct($level, $bubble);
    }

    protected function write(array|\Monolog\LogRecord $record):void
    {

        $data = array(
            'nom_hote_log'       => gethostname(),
            'niveau_log'  => $record['level_name'],
            'ip_addr_log' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'agent_utilisateur_log'  => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT']: null,
            'identifiant_log'       => Auth::id() > 0 ? @Auth::user()->login_users : null,
            'utilisateur_log'       => Auth::id() > 0 ? @Auth::user()->name." ".@Auth::user()->prenom_users : null,
            'role_log'       => Auth::id() > 0 ? @Menu::get_menu_profil(Auth::user()->id) : null,
            'action_log'       => $record['message'],
            'code_piece_log'       => isset($record['context']['code_piece']) ? $record['context']['code_piece'] : null,
            'menu_log'       => isset($record['context']['menu']) ? $record['context']['menu'] : null,
            'etat_log'       => isset($record['context']['etat']) ? $record['context']['etat'] : null,
            'objet_log' =>  isset($record['context']['objet']) ? $record['context']['objet'] : null,
            'created_at'  => $record['datetime']->format('Y-m-d H:i:s'),
            'updated_at'  => $record['datetime']->format('Y-m-d H:i:s')
        );

        DB::connection($this->connection)->table($this->table)->insert($data);
    }
}
