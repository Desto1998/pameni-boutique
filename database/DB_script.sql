Create
database if not exists gsc-app;

USE
`gsc-app`;
drop table if exists devises;
create table devises
(
    devise_id  int primary key AUTO_INCREMENT,
    nom_devise varchar(230) not null,
    symbole    varchar(6)   not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists pays;
create table pays
(
    pays_id    int primary key AUTO_INCREMENT,
    nom_pays   varchar(255) not null,
    code_pays  varchar(255) not null,
    drapeau    varchar(255) null,
    visible    int       default 0,
    iddevise   int null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists clients;
create table clients
(
    client_id       int primary key AUTO_INCREMENT,
    raison_s_client varchar(1000) null,
    nom_client      varchar(255) null,
    prenom_client   varchar(255) null,
    email_client    varchar(255) null,
    phone_1_client  varchar(20) not null,
    phone_2_client  varchar(20) null,
    idpays          int null,
    ville_client    varchar(255) null,
    adresse_client  varchar(255) null,
    logo_client     varchar(255),
    date_ajout      date        not null,
    contribuable    varchar(100) default null,
    slogan          varchar(500) null,
    siteweb         varchar(500) null,
    rcm             varchar(500) null,
    postale         varchar(50) null,
    type_client     varchar(50) null,
    iduser          int null,
    iddevise        int null,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists fournisseurs;
create table fournisseurs
(
    fournisseur_id int primary key AUTO_INCREMENT,
    raison_s_fr    varchar(255) null,
    nom_fr         varchar(255) null,
    prenom_fr      varchar(255) null,
    email_fr       varchar(255) null,
    phone_1_fr     varchar(20) not null,
    phone_2_fr     varchar(20) null,
    idpays         int null,
    ville_fr       varchar(255) null,
    adresse_fr     varchar(255) null,
    logo_fr        varchar(255) null,
    date_ajout_fr  date        not null,
    contribuable   varchar(100) default null,
    slogan         varchar(500) null,
    siteweb        varchar(500) null,
    rcm            varchar(500) null,
    postale        varchar(50) null,
    type_fr        varchar(50) null,
    iduser         int         not null,
    iddevise       int null,
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- actuaNum will increment when product is added is use to generate product reference
drop table if exists categories;
create table categories
(
    categorie_id    int primary key AUTO_INCREMENT,
    titre_cat       varchar(255) not null,
    code_cat        varchar(10)  not null,
    description_cat varchar(1000) null,
    actualNum       int       default 0,
    iduser          int,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists produits;
create table produits
(
    produit_id          int primary key AUTO_INCREMENT,
    reference           varchar(20)   not null,
    titre_produit       varchar(1000) not null,
    description_produit varchar(1000) null,
    quantite_produit    int           not null,
    prix_produit        float         not null,
    idcategorie         int null,
    iduser              int           not null,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists charges;
create table charges
(
    charge_id   int primary key AUTO_INCREMENT,
    titre       varchar(255) not null,
    description varchar(1000) null,
    type_charge int,
    alerte      int,
    iduser      int,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists taches;
create table taches
(
    tache_id   int primary key AUTO_INCREMENT,
    date_debut date  not null,
    date_fin   date  not null,
    date_ajout date  not null,
    raison     varchar(1000) null,
    nombre     int   not null,
    prix       float not null,
    idcharge   int   not null,
    iduser     int   not null,
    statut      int       default 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists devis;
create table devis
(
    devis_id             int primary key AUTO_INCREMENT,
    reference_devis      varchar(20) not null,
    date_devis           date        not null,
    statut               int       default 0,
    idclient             int         not null,
    validite             int         not null,
    tva_statut           int       default 0,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    date_paie            date null,
    echeance             date null,
    iduser               int         not null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists factures;
create table factures
(
    facture_id           int primary key AUTO_INCREMENT,
    reference_fact       varchar(20) not null,
    date_fact            date        not null,
    statut               int       default 0,
    tva_statut           int       default 0,
    idclient             int         not null,
    objet                varchar(1000) null,
    disponibilite        varchar(1000) null,
    garentie             varchar(1000) null,
    condition_financiere varchar(1000) null,
    iduser               int         not null,
    iddevis              int null,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists produit_factures;
create table produit_factures
(
    produit_f_id int primary key AUTO_INCREMENT,
    quantite     int   not null,
    prix         float not null,
    remise       float null,
    tva          float null,
    num_serie    varchar(255) null,
    idfacture    int   not null,
    idproduit    int   not null,
    iduser       int   not null,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists commentaires;
create table commentaires
(
    commentaire_id     int primary key AUTO_INCREMENT,
    message            varchar(1000) not null,
    date_commentaire   date          not null,
    statut_commentaire int       default 0,
    idcommande         int null,
    iddevis            int null,
    idfacture          int null,
    iduser             int           not null,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists paiements;
create table paiements
(
    paiement_id   int primary key AUTO_INCREMENT,
    mode          varchar(255) not null,
    date_paiement date         not null,
    description   varchar(1000) null,
    montant       float        not null,
    statut        int       default 1,
    idcommande    int null,
    iddevis       int null,
    idfacture     int null,
    iduser        int          not null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists pocedes;
create table pocedes
(
    pocede_id  int primary key AUTO_INCREMENT,
    quantite   int   not null,
    prix       float not null,
    remise     float     default 0,
    tva        float     default 0,
    num_serie  varchar(1000) null,
    iddevis    int   not null,
    idproduit  int   not null,
    iduser     int   not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists commandes;
create table commandes
(
    commande_id        int primary key AUTO_INCREMENT,
    reference_commande varchar(20)   not null,
    objet              varchar(1000) not null,
    date_commande      date          not null,
    statut             int       default 0,
    tva_statut         int       default 0,
    idfournisseur      int           not null,
    service            varchar(1000) null,
    direction          varchar(1000) null,
    mode_paiement      varchar(1000) null,
    condition_paiement varchar(1000) null,
    delai_liv          varchar(1000) null,
    observation        varchar(1000) null,
    note               varchar(1000) null,
    lieu_liv           varchar(1000) null,
    iduser             int           not null,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists comportes;
create table comportes
(
    comporte_id int primary key AUTO_INCREMENT,
    quantite    int   not null,
    prix        float not null,
    remise      float     default 0,
    tva         float     default 0,
    idcommande  int   not null,
    idproduit   int   not null,
    iduser      int   not null,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists pieces;
create table pieces
(
    piece_id   int primary key AUTO_INCREMENT,
    chemin     varchar(500) null,
    ref        varchar(50),
    remise     float null,
    idcommande int null,
    idfacture  int null,
    date_piece date null,
    iddevis    int null,
    iduser     int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists complements;
create table complements
(
    complement_id int primary key AUTO_INCREMENT,
    quantite      int   not null,
    prix          float not null,
    remise        float     default 0,
    tva           float     default 0,
    idproduit     int   not null,
    iddevis       int   not null,
    iduser        int   not null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists num_factures;
create table num_factures
(
    idnum_facture int primary key AUTO_INCREMENT,
    numero        int,
    date_num      date,
    iddevis       int null,
    iduser        int null,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists menus;
create table menus
(
    menu_id     int primary key AUTO_INCREMENT,
    position    int,
    code        varchar(5),
    label       varchar(100),
    description varchar(1000) null,
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


drop table if exists user_menus;
create table user_menus
(
    user_menu_id int primary key AUTO_INCREMENT,
    idmenu       int,
    userid       int,
    iduser       int,
--     FOREIGN KEY (userid) REFERENCES users(id),
    FOREIGN KEY (idmenu) REFERENCES menus (menu_id),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists caisses;
create table caisses
(
    caisse_id      int primary key AUTO_INCREMENT,
    montant        float not null,
    raison         varchar(255) null,
    date_depot     date,
    description    varchar(1000) null,
    idtache        int null,
    identre        int null,
    idpaiement     int null,
    type_operation int   not null,
    iduser         int   not null,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

drop table if exists entrees;
create table entrees
(
    entre_id          int primary key AUTO_INCREMENT,
    raison_entre      varchar(255) not null,
    montant_entre     float        not null,
    description_entre varchar(1000) null,
    date_entre        date,
    statut_entre      int       default 1,
    iduser            int          not null,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
