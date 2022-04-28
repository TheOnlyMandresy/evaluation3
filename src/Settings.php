<?php

namespace System;

class Settings
{
    // Database
    protected const DB_NAME = 'kgb';
    protected const DB_HOST = 'localhost';
    protected const DB_USER = 'root';
    protected const DB_PASS = '';

    // Website
    protected const WEBSITE = 'KGB';
    protected const MISSION_STATE = [
        'Aucune activité',
        'En préparation',
        'en cours',
        'terminé',
        'échec'
    ];

    // About Website
    protected const CMS_VERSION = '1.1';
    protected const CMS_AUTHOR = 'Mandresy';
    protected const CMS_AUTHOR_URL = 'https://www.instagram.com/monsieur.rvy/';

    // Metas
    protected const META_DESC = "Hypnos est un groupe hôtelier fondé en 2004. Propriétaire de 7 établissements dans les quatre
    coins de l’hexagone, chacun de ces hôtels s’avère être une destination idéale pour les couples
    en quête d’un séjour romantique à deux." ;
    protected const META_IMG = 'logo.png' ;

}