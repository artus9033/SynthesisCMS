<?php

return [
	'tool_compile_cms_resources' => 'Skompiluj Zasoby CMS\'a',
	'toast_compilation_finished' => 'Kompilacja zakończona! Proszę przeczytać dziennik kompilatora',
	'toast_error_trying_to_run_compiler' => 'Błąd podczas uruchamiania kompilatora. Proszę spróbować ręcznie poprzez wiersz polecenia...',
	'btn_compile_now' => 'Kompiluj Zasoby',
	'btn_rebuild_node_sass_now' => 'Rekompiluj Node SASS',
	'tooltip_btn_rebuild_node_sass_now' => 'To może być konieczne, jeżeli przeniosłeś stronę na nowy serwer, aktualizowałeś/zmieniłeś system operacyjny serwera, lub kompilacja zasobów rzuca błąd z Node SASS binding.',
	'btn_npm_install_now' => 'Instaluj moduły',
	'tooltip_btn_npm_install' => 'To po prostu uruchamia komendę `npm install`. Może być pomocne, jeśli w trakcie kompilacji zasobów występują błędy lub jeśli usunąłeś katalog node_modules.',
	'btn_delete_node_modules_now' => 'Usuń katalog node_modules',
	'tooltip_btn_delete_node_modules_now' => 'Usuwa katalog node_modules. UWAGA: po tym nie będziesz mógł kompilować zasobów dopóki nie zainstalujesz od nowa modułów. Może być pomocne, gdy podczas kompilacji pojawiają się błędy.',
	'header_compiler_log' => 'Dziennik Kompilatora',
	'info_compilation_may_take_some_time' => 'Kompilacja zasobów potrzebna jest, gdy dokonano ręcznych zmian w zasobach (w katalogu resources) SynthesisCMS lub usunięto katalog zasobów. Kompilacja może zająć trochę czasu. Gdy się skończy, jej wynik zostanie wyświetlony tutaj.',
	'toast_optimization_finished' => 'Optymalizacja zakończona! Proszę przeczytać dziennik optymalizatora.',
	'toast_error_trying_to_run_optimizer' => 'Błąd podczas uruchamiania optymalizatora...',
	'btn_optimize_now' => 'Optymalizuj',
	'header_optimizer_log' => 'Dziennik Optymalizatora',
	'info_optimization_may_take_some_time' => 'Optymalizacja zwiększa wydajność SynthesisCMS. Zalecana jest, gdy wysłanie odpowiedzi zajmuje serwerowi zbyt dużo czasu (czyli kiedy `strona długo się ładuje`). Optymalizacja może zająć trochę czasu. Gdy się skończy, jej wynik zostanie wyświetlony tutaj. UWAGA: po optymalizacji zalogowani użytkownicy mogą zostać jednorazowo wylogowani.',
];

?>
