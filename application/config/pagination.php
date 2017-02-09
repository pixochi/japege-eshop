<?php

$config['base_url'] = base_url('search');
$config['per_page'] = 9;
$config['use_page_numbers'] = TRUE;
$config['uri_segment'] = 2;
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['first_tag_open'] = '<ul>';
$config['first_tag_close'] = '</ul>';
$config['last_tag_open'] = '<ul>';
$config['last_tag_close'] = '</ul>';
$config['cur_tag_open'] = '<li class="active"><a>';
$config['cur_tag_close'] = '</a></li>';
$config['next_tag_open'] = $config['prev_tag_open'] = '<i style="display:none;">';
$config['next_tag_close'] = $config['prev_tag_close'] = '</i>';
?>