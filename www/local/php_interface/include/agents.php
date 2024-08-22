<?php

function CheckUserCount()
{
    $date = new DateTime();
    $date = \Bitrix\Main\Type\DateTime::createFromTimestamp($date->getTimestamp());
    $lastDate = COption::GetOptionString('main', 'last_date_agent_checkUserCount');
    $arFilter = [];

    if ($lastDate) {
        $arFilter['>=DATE_REGISTER'] = $lastDate;
    }

    COption::SetOptionString('main', 'last_date_agent_checkUserCount', $date->format('Y-m-d H:i:s'));

    $users = CUser::GetList("date_register", "asc", $arFilter);
    $arUsers = [];
    while ($user = $users->Fetch()) {
        $arUsers[] = $user;
    }
    if (!$lastDate) {
        $lastDate = $arUsers[0]['DATE_REGISTER'];
    }

    $difference = intval(abs(strtotime($date->toString()) - strtotime($lastDate)));
    $days = round($difference / (60 * 60 * 24));
    $countUsers = count($arUsers);
    $queryAdmins = CUser::GetList('', '', ['GROUPS_ID' => 1]);

    while ($admin = $queryAdmins->Fetch()) {
        CEvent::Send(
            'COUNT_REGISTERED_USERS',
            's1',
            ['COUNT_USERS' => $countUsers, 'COUNT_DAYS' => $days, 'EMAIL_TO' => $admin['EMAIL']],
            'Y',
            '33'
        );
    }

    return "CheckUserCount();";
}