<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function(){
    Container::make('theme_options', 'Réglages des biens')
        ->add_tab('Notaire',[
            Field::make('text','taux_notaire','Notaire')
            ->set_attribute('type','number'),
        ])
        
        ->add_tab('Foncière',[
            Field::make('text','taux_fonciere','Foncière')
            ->set_attribute('type','number'),
        ]);

    Container::make('post_meta', 'Information sur le bien')
        ->where('post_type','=','bien_immobilier')
        ->add_tab('Type de Bien',[
            Field::make('select','type_bien','Appartement, Immeuble ou Parking ?')
                ->add_options([
                    'appartement' => 'Appartement',
                    'immeuble' => 'Immeuble',
                    'parking' => 'Parking'
                ])
        ])
    
        ->add_tab('Adresse',[
            Field::make('text','adresse_texte','Adresse')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'type_bien',
                        'value' => 'parking',
                        'compare' => '!=' // Afficher l'adresse pour tout sauf le parking
                    ]
                ]),
            Field::make('text','codepostal','Code Postal')
                ->set_attribute('type','number')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'type_bien',
                        'value' => 'parking',
                        'compare' => '!='
                    ]
                ]),
            Field::make('text','ville','Ville')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'type_bien',
                        'value' => 'parking',
                        'compare' => '!='
                    ]
                ]),
            Field::make('text','annee','Année de construction')
                ->set_attribute('type','date')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'type_bien',
                        'value' => 'parking',
                        'compare' => '!='
                    ]
                ]),
        ])
        
        ->add_tab('Information',[
            Field::make('text','piece','Nombre de pièce')
                ->set_attribute('type','number'),
            Field::make('text','metre','M²')
                ->set_attribute('type','number'),
            Field::make('text','etage','Etage')
                ->set_attribute('type','number'),
            Field::make('checkbox','cave','Cave'),
            Field::make('checkbox','ascenseur','Ascenseur'),
            Field::make('checkbox','parking','Parking / Garage'),
        ])
        ->add_tab('Extra',[
            Field::make('checkbox','terrasse','Terrasse'),
            Field::make('checkbox','patio','Patio'),
            Field::make('checkbox','jardin','Jardin'),
        ])
        ->add_tab('Intégrations',[
            Field::make( 'multiselect', 'chauffage', __( 'Type(s) de chauffage' ) )
            ->add_options( array(
                'central' => 'Central',
                'electrique' => 'Electrique',
                'planche_chauffant' => 'Plancher chauffant',
                'gaz' => 'Gaz',
            ))
        ])
        ->add_tab('Réparations',[
            Field::make('checkbox','terrasse','Terrasse'),
        ])
        ->add_tab('Copropriété',[
            Field::make('checkbox','copropriete','Copropriété'),
            Field::make('text','quotepart','Quotepart')
            ->set_attribute('type','number'),
            Field::make('checkbox','procedure','Procédure'),
        ])
        ->add_tab('Images',[
            Field::make('complex', 'images_bien', 'Images du bien')
                ->add_fields(array(
                    Field::make('image', 'image', 'Image')
                ))
                ->set_max(6) // Limite à 6 images
        ]);
});
