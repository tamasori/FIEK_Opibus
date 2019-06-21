<?php return [

//Config::get("constants.menus.adminsitration");

"menus" => [

    'administration' => [
        ['name' => "Foglalasok kezelése",   'url' => "/foglalas",               'perm' => "labs",       'icon' => '<i class="fas fa-book"></i>'],
        ['name' => "Laborok",               'url' => "/laborok",                'perm' => "labs",       'icon' => '<i class="fas fa-flask"></i>'],
        ['name' => "Eszközök",              'url' => "/eszkozok",               'perm' => "items",      'icon' => '<i class="fas fa-desktop"></i>'],
        ['name' => "Felhasználók",          'url' => "/felhasznalok",           'perm' => "users",      'icon' => '<i class="fas fa-users"></i>'],
        ['name' => "Felhasználói csoportok",'url' => "/felhasznalo-csoportok",  'perm' => "groups",     'icon' => '<i class="fas fa-users-cog"></i>'],
        ['name' => "Hibabejelentések",      'url' => "/hiba-bejelentesek",      'perm' => "errors",     'icon' => '<i class="fas fa-exclamation-triangle"></i>'],
        ['name' => "Hírek",                 'url' => "/hirek",                  'perm' => "news",       'icon' => '<i class="fas fa-newspaper"></i>'],
        ['name' => "Felügyelet jelenlét",   'url' => "/felugyelet-jelenlet",    'perm' => "overwatch",  'icon' => '<i class="fas fa-user-secret"></i>'],
        ['name' => "Email szövegek",        'url' => "/email-szovegek",         'perm' => "emails",     'icon' => '<i class="fas fa-envelope-open-text"></i>'],
        ['name' => "Szövegek",              'url' => "/szovegek",               'perm' => "texts",      'icon' => '<i class="fas fa-file-alt"></i>']
    ],
    'altalanos' => [
        ['name' => "Vezérlőpult",   'url' => "/",                   'perm' => "dashboard",      'icon' => '<i class="fas fa-tachometer-alt"></i>'],
        ['name' => "Foglalás",      'url' => "/foglalas/uj",        'perm' => "rent",           'icon' => '<i class="fas fa-file-signature"></i>'],
        ['name' => "Információk",   'url' => "/informaciok",        'perm' => "information",    'icon' => '<i class="fas fa-info"></i>']
    ]

]

];
?>