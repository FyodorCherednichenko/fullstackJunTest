<?php

declare(strict_types=1);

# Использовать данные:

// Список районов
$areas = array(
    1 => '5-й поселок',
    2 => 'Голиковка',
    3 => 'Древлянка',
    4 => 'Заводская',
    5 => 'Зарека',
    6 => 'Ключевая',
    7 => 'Кукковка',
    8 => 'Новый сайнаволок',
    9 => 'Октябрьский',
    10 => 'Первомайский',
    11 => 'Перевалка',
    12 => 'Сулажгора',
    13 => 'Университетский городок',
    14 => 'Центр',
);

// Близкие районы, связь осуществляется по индентификатору района из массива $areas
$nearby = array(
    1 => array(12, 11),
    2 => array(5, 7, 6, 8),
    3 => array(11, 13),
    4 => array(10, 9, 12),
    5 => array(2, 6, 7, 8),
    6 => array(5, 2, 7, 8),
    7 => array(2, 5, 6, 8),
    8 => array(6, 2, 7, 5),
    9 => array(10, 14),
    10 => array(9, 14, 12),
    11 => array(13, 3, 1, 12),
    12 => array(1, 10),
    13 => array(11, 1, 12),
    14 => array(9, 10),
);

// список сотрудников
$workers = array(
    0 => array(
        'login' => 'login1',
        'area_name' => 'Октябрьский',
    ),
    1 => array(
        'login' => 'login2',
        'area_name' => 'Зарека',
    ),
    2 => array(
        'login' => 'login3',
        'area_name' => 'Сулажгора',
    ),
    3 => array(
        'login' => 'login4',
        'area_name' => 'Древлянка',
    ),
    4 => array(
        'login' => 'login5',
        'area_name' => 'Центр',
    ),
);

function emplSearch(string $district_name): string|null|array
{
    global $workers;
    global $nearby;
    global $areas;
    $neighbor_districts = [];
    $logins = [];

    if (!function_exists('login_search')) {
        function login_search(array $workers, string $district_name): string|null
        {
            foreach ($workers as $worker) {
                if (in_array($district_name, $worker)) {
                    return $worker['login'];
                }
            }
            return null;
        }
    }

    $login = login_search($workers, $district_name);

    if ($login) return $login;

    $district_number = array_search($district_name, $areas);

    if ($district_number && $login != null) {
        return $login;
    }

    foreach ($nearby as $neighbors)
    {
        if (in_array($district_number, $neighbors)) {
            foreach ($neighbors as $neighbor) {
                if (!in_array($areas[$neighbor], $neighbor_districts) && $areas[$neighbor] !== $district_name)
                $neighbor_districts[] = $areas[$neighbor];
            }
        }
    }

    foreach ($neighbor_districts as $neighbor_district) {
        if (login_search($workers, $neighbor_district)) {
            $logins[] = login_search($workers, $neighbor_district);
        }
    }

    if (count($logins) > 0) {
        return $logins;
    } else {
        return null;
    }

}

print_r (emplSearch('5-й поселок')); echo PHP_EOL;
print_r (emplSearch('Голиковка')); echo PHP_EOL;
print_r (emplSearch('Древлянка')); echo PHP_EOL;
print_r (emplSearch('Заводская')); echo PHP_EOL;
print_r (emplSearch('Зарека')); echo PHP_EOL;
print_r (emplSearch('Ключевая')); echo PHP_EOL;
print_r (emplSearch('Кукковка')); echo PHP_EOL;
print_r (emplSearch('Новый сайнаволок')); echo PHP_EOL;
print_r (emplSearch('Октябрьский')); echo PHP_EOL;
print_r (emplSearch( 'Первомайский')); echo PHP_EOL;
print_r (emplSearch( 'Перевалка')); echo PHP_EOL;
print_r (emplSearch( 'Сулажгора')); echo PHP_EOL;
print_r (emplSearch( 'Университетский городок')); echo PHP_EOL;
print_r (emplSearch( 'Центр')); echo PHP_EOL;
