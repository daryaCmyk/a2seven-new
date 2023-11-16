<?php

get_header();

global $idContactPage; 
global $idVacancyPage; 

if( is_page( $idContactPage ) ): get_template_part('components/pages/page-contacts');
elseif( is_page($idVacancyPage) ): get_template_part('components/pages/vacancy');
elseif( is_subpage($idVacancyPage) ): get_template_part('components/pages/subvacancy');
else: get_template_part('components/pages/text'); // Текстовая страница
endif;


get_footer();
