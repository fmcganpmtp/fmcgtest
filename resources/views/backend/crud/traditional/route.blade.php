Route::get('{{ $slug }}', '{{ $class }}Controller@index')->name('{{ $route }}');
Route::post('{{ $slug }}', '{{ $class }}Controller@list')->name('{{ $route }}.list');
Route::get('{{ $slug }}/create', '{{ $class }}Controller@create')->name('{{ $route }}.create');
Route::post('{{ $slug }}/create', '{{ $class }}Controller@store')->name('{{ $route }}.store');
Route::get('{{ $slug }}/edit/__[{{ $variable }}]__', '{{ $class }}Controller@edit')->name('{{ $route }}.edit');
Route::patch('{{ $slug }}/edit/__[{{ $variable }}]__', '{{ $class }}Controller@update')->name('{{ $route }}.update');
Route::post('{{ $slug }}/delete/__[{{ $variable }}]__', '{{ $class }}Controller@destroy')->name('{{ $route }}.destroy');