<?php

namespace App\Utility;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
//use Symfony\Component\HttpFoundation\Request;

class ApiUtilities
{
    /**
     * @return DateTimeInterface
     */
    public function getDateTime(): DateTimeInterface
    {
        return DateTime::createFromFormat(
            'Y-m-d H:i:s',
            date('Y-m-d H:i:s'),
            new DateTimeZone('Europe/London')
        );
    }

//    /**
//     * @param Request $request
//     * @return Request
//     */
//    public function transformJsonBody(Request $request): Request
//    {
//        $data = json_decode($request->getContent(), true);
//
//        if ($data === null) {
//            return $request;
//        }
//
//        $request->request->replace($data);
//
//        return $request;
//    }
}