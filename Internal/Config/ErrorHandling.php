<?php return
[
    //--------------------------------------------------------------------------------------------------
    // Error Handling
    //--------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : Copyright (c) 2012-2016, ZN Framework
    //
    //--------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------
    // Exceptions
    //--------------------------------------------------------------------------------------------------
    //
    // Exceptions config.
    //
    //--------------------------------------------------------------------------------------------------
    'exceptions' =>
    [
        //----------------------------------------------------------------------------------------------
        // Argument Passed Error Type
        //----------------------------------------------------------------------------------------------
        //
        // Geçersiz parametre hatalarından kaynaklanan hata mesajlarını konum olarak kullanılan
        // kütüphanelerin iç yapısında mı yoksa dış yapımısında mı göstereceğini belirler.
        //
        // Kullanılabilir Seçenekler: external, internal
        //
        //----------------------------------------------------------------------------------------------
        'invalidParameterErrorType' => 'external' // external, internal
    ]
];