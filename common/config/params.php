<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'bsVersion' => '5.x', // this will set globally `bsVersion` to Bootstrap 5.x for all Krajee Extensions
    'folder_upload'     => [
        'dokter' => Yii::getAlias('@rootpath') . '/upload/dokter/',
        'klinik' => Yii::getAlias('@rootpath') . '/upload/klinik/',
        'perawatan' => Yii::getAlias('@rootpath') . '/upload/perawatan/',
        'produk' => Yii::getAlias('@rootpath') . '/upload/produk/',
        'produk_kategori' => Yii::getAlias('@rootpath') . '/upload/produk_kategori/',
        'promo' => Yii::getAlias('@rootpath') . '/upload/promo/',
    ],
];
