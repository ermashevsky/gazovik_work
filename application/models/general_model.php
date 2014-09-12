<?php

/**
 * Clients_model
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Models.Report_Model
 * @author   Ермашевский Денис <ermashevsky@gmail.com>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://www.ci2.lcl/
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Класс Report содержит методы работы  с отчетами
 *
 * @category PHP
 * @package  Models.Clients_Model
 * @author   Ермашевский Денис <ermashevsky@gmail.com>
 * @access   public
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version  Release: 145
 * @link     http://www.reportsender.lcl/
 */
class General_model extends CI_Model {

    /**
     * Унифицированный метод-конструктор __construct()
     *
     * @author Ермашевский Денис
     */
    function __construct() {
        parent::__construct();
        $this->load->library('email');
    }

    function transCode($code) {
        switch ($code) {
            case 'IR':
                return "Входящий неотвеченный";
            case 'IA':
                return "Разговор";
            case 'I':
                return "Входящий отвеченный";
            case 'O':
                return "Исходящий";
            case 'IT':
                return "Перевод звонка";
            case 'T':
                return "Входящий переведенный";
        }
    }
    
    function transCode2($code) {
        switch ($code) {
            case 'IR':
                return "Входящий звонок";
            case 'IA':
                return "Разговор";
            case 'I':
                return "Входящий отвеченный";
            case 'O':
                return "Исходящий";
            case 'IT':
                return "Перевод звонка";
            case 'T':
                return "Переведенный завершен";
        }
    }
    
    function transCode3($code) {
        switch ($code) {
            case 'IR':
                return "Входящий звонок";
            case 'IA':
                return "Разговор";
            case 'I':
                return "Звонок завершен";
            case 'O':
                return "Исходящий";
            case 'IT':
                return "Перевод звонка";
            case 'T':
                return "Входящий переведенный";
        }
    }

    function formatString($call_id, $call_type) {

        if ($call_type === "T") {
            return " <a href='#' onclick=getCallHistory('" . $call_id . "'); return false;><i class='icon-info-sign'></i></a>";
        }
    }

    function getCallHistory($call_id) {
        $this->db->select('id, call_id, internal_number, call_date, call_time, duration, call_type, dst, src');
        $this->db->from('cdr');
        $this->db->where("call_id", $call_id);
        $results = $this->db->get();
        
        $data = array();
        
        if (0 < $results->num_rows) {
            foreach ($results->result() as $row) {
                $general = new General_model();
                $general->id = $row->id;
                $general->internal_number = $row->internal_number;
                $general->call_date = $row->call_date;
                $general->call_time = $row->call_time;
                $general->duration = $row->duration;
                $general->call_type = $this->transCode2($row->call_type);
                $general->dst = $row->dst;
                $general->src = $row->src;
                $data[$general->id] = $general;
            }
        }
        return $data;
    }

    function getCallDataForTable($phone, $group) {
        if ($group !== 'admin') {
            $this->db->select('call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered, contactName');
            $this->db->from('cdr');
            $this->db->join('contactGroup', 'contactGroup.external_number = cdr.dst', 'left');
            $this->db->where_in("call_type", array('I', 'T'));
            $this->db->where("internal_number", $phone);
            $this->db->or_where("unanswered", 'yes');
            $this->db->where("internal_number", $phone);
            $this->db->where("duration", "00:00:00");
            $this->db->order_by('cdr.id', "DESC");
            $results = $this->db->get();
        } else {
            $this->db->select('call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered, contactName');
            $this->db->from('cdr');
            $this->db->join('contactGroup', 'contactGroup.external_number = cdr.dst', 'left');
            $this->db->where_in("call_type", array('I', 'T'));
            $this->db->or_where("unanswered", 'yes');
            $this->db->where("duration", "00:00:00");
            $this->db->order_by('cdr.id', "DESC");
            $results = $this->db->get();
            //$this->db->where("internal_number", $phone);
        }
        //$this->db->order_by('id DESC');


        if (0 < $results->num_rows) {
            $output = '{ "aaData": [';
            $n = 1;
            foreach ($results->result() as $row) {
                if(strlen($row->dst) > 4){
                $output .= '["' . $n++ . '","' . $row->internal_number . '","' . $row->call_date . '","' . $row->call_time . '","' . $row->duration . '","' . $this->transCode($row->call_type) . '","' . $row->src . '","' . $row->dst . $this->formatString($row->call_id, $row->call_type) . '","' . $row->contactName . '"],';
                }
            }
            $output = substr_replace($output, "", -1);
            $output .= '] }';
        }
        echo $output;
    }
    
    function getAllStatisticData(){
            $this->db->select('cdr.id, call_id, internal_number, call_date, call_time, duration, call_type, dst, src, unanswered, contactName');
            $this->db->from('cdr');
            $this->db->join('contactGroup', 'contactGroup.external_number = cdr.dst', 'left');
            $this->db->where_in("call_type", array('I', 'T'));
            $this->db->or_where("unanswered", 'yes');
            $this->db->where("duration", "00:00:00");
            $this->db->order_by('cdr.id', "DESC");
            $results = $this->db->get();
            $data = array();
            $general = array();
            
        if (0 < $results->num_rows) {
            foreach ($results->result() as $row) {
                
                $general['id'] = $row->id;
                $general['call_id'] = $row->call_id;
                $general['internal_number'] = $row->internal_number;
                $general['call_date'] = $row->call_date;
                $general['call_time'] = $row->call_time;
                $general['duration'] = $row->duration;
                $general['call_type'] = $this->transCode2($row->call_type);
                $general['dst'] = $row->dst;
                $general['src'] = $row->src;
                $general['contactName'] = $row->contactName;
                $data[$general['id']] = $general;
            }
        }
        return $data;
    }
    
    function deleteStatisticData(){
        
        
        $this->db->delete('cdr');
        $this->db->where_not_in('id', date("d/m/Y",  now()));
        return $this->db->affected_rows();
    }
    
    function getCallDataForDay($phone, $group) {
        if ($group !== 'admin') {
            $this->db->select('call_id, internal_number, call_date, call_time, duration, call_type, dst, src, contactName');
            $this->db->from('cdr');
            $this->db->join('contactGroup', 'contactGroup.external_number = cdr.dst', 'left');
            $this->db->where_in("call_type", array('IR','IA','I'));
            $this->db->where("internal_number", $phone);
            $this->db->where("call_date", date('d/m/Y',now()));
            $this->db->order_by('cdr.id', "DESC");
            $results = $this->db->get();
        } else {
            $this->db->select('call_id, internal_number, call_date, call_time, duration, call_type, dst, src, contactName');
            $this->db->from('cdr');
            $this->db->join('contactGroup', 'contactGroup.external_number = cdr.dst', 'left');
            $this->db->where_in("call_type", array('IR','IA','I'));
            $this->db->where("call_date", date('d/m/Y',now()));
            $this->db->order_by('cdr.id', "DESC");
            $results = $this->db->get();
            //$this->db->where("internal_number", $phone);
        }
        //$this->db->order_by('id DESC');


        if (0 < $results->num_rows) {
            $output = '{ "aaData": [';
            $n = 1;
            foreach ($results->result() as $row) {
                if(strlen($row->dst) > 4){
                $output .= '["' . $n++ . '","' . $row->internal_number . '","' . $row->call_date . '","' . $row->call_time . '","' . $row->duration . '","' . $this->transCode3($row->call_type) . '","' . $row->src . '","' . $row->dst . $this->formatString($row->call_id, $row->call_type) . '","' . $row->contactName . '"],';
                }
            }
            $output = substr_replace($output, "", -1);
            $output .= '] }';
        }
        echo $output;
    }

    function getContactGroup($external_number) {
        $this->db->select('contactName');
        $this->db->from('contactGroup');
        $this->db->where("external_number", $external_number);
        $results = $this->db->get();
        $data = array();
        if (0 < $results->num_rows) {

            foreach ($results->result() as $row) {
                return $row->contactName;
            }
        }
    }

    function getPhoneDeptsRecord($id) {
        $this->db->select('id, external_number, contactName');
        $this->db->from('contactGroup');
        $this->db->where('id', $id);

        $results = $this->db->get();

        $data = array();
        if (0 < $results->num_rows) {

            foreach ($results->result() as $row) {
                $general = new General_model();
                $general->id = $row->id;
                $general->external_number = $row->external_number;
                $general->contactName = $row->contactName;
                $data[$general->id] = $general;
            }
        }
        return $data;
    }

    function getPhoneDepts() {
        $this->db->select('id, external_number, contactName');
        $this->db->from('contactGroup');
        $results = $this->db->get();

        $data = array();
        if (0 < $results->num_rows) {

            foreach ($results->result() as $row) {
                $general = new General_model();
                $general->id = $row->id;
                $general->external_number = $row->external_number;
                $general->contactName = $row->contactName;
                $data[$general->id] = $general;
            }
        }
        return $data;
    }

    function getMailSettings() {
        $this->db->select('*');
        $this->db->from('mailsettings');
        $results = $this->db->get();

        $data = array();
        if (0 < $results->num_rows) {

            foreach ($results->result() as $row) {
                $general = new General_model();
                $general->id = $row->id;
                $general->smtp_host = $row->smtp_host;
                $general->smtp_port = $row->smtp_port;
                $general->smtp_user = $row->smtp_user;
                $general->smtp_pass = $row->smtp_pass;
                $general->smtp_timeout = $row->smtp_timeout;

                $data[$general->id] = $general;
            }
        }
        return $data;
    }

    function updateSmtpParameters($id, $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $smtp_timeout) {
        $data = array(
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'smtp_timeout' => $smtp_timeout
        );

        $this->db->where('id', $id);
        $this->db->update('mailsettings', $data);
    }

    function insertNewPhoneDeptsData($additional_data) {
        $this->db->insert('contactGroup', $additional_data);
    }

    function deletePhoneDeptsRecord($id) {
        $this->db->delete('contactGroup', array('id' => $id));
    }

    function deleteUserRecord($id) {
        $this->db->delete('users', array('id' => $id));
        $this->db->delete('users_groups', array('user_id' => $id));
    }

    function updatePhoneDeptsRecord($id, $external_number, $contactName) {
        $data = array(
            'external_number' => $external_number,
            'contactName' => $contactName
        );

        $this->db->where('id', $id);
        $this->db->update('contactGroup', $data);
    }

    function updateSendCalls($call_id) {

        $this->db->where('call_id', $call_id);
        $this->db->set("sent", "yes");
        $this->db->update('cdr');
    }

}

//End of file report_model.php
//Location: ./models/report_model.php
    