<?php
$dir = "/mnt/ccdobs/ccdobsDB/tmp"; // Директория с файлами
$files = scandir( $dir ); // Прочёсываем директорию
$time = time(); // Текущее время
$life_file = 3600; // Время жизни файла в секундах
 
// Отнимаем от текущего времени время жизни файла
$time = $time - $life_file;
 
// В цикле обходим массив
foreach( $files as $file )
{
    if( $file != "." && $file != ".." )
    {
        $file = $dir.$file;
        $filemtime = filemtime( $file ); // Время создания или модификации файла
                
        // Удаляем, если нужно
        if( $filemtime <= $time )
        {
            unlink( $file );
        }
    }
}
 
