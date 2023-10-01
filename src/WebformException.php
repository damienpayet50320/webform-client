<?php

namespace Proloweb\WebformClient;

class WebformException extends \Exception
{
    const CRM_INSTANCE_ID_EMPTY_MESSAGE = "Bad Request - please set your CrmInstanceId";
    const CRM_INSTANCE_ID_EMPTY_CODE = 400;
}
