<?php


namespace EnseignantEnseignement\Modele\Filter;

use DeepCopy\Filter\Filter as FilterFilter;
use Laminas\InputFilter\InputFilter;
use Laminas\Filter;
use Laminas\Validator;


class EnseignementFilter extends InputFilter{

    public function FilterForm(){

        $this->add([
            "name"=>"id",
            "required"=>false,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"L'id doit être un entier"
                        ]
                    ]
                ]
            ]
            ]);

        $this->add([

            "name"=>"training",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY => "Le champ formation ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>5,
                        "max"=>50,
                        "messages"=>[
                            Validator\StringLength::TOO_LONG=>"Le nom de la formation ne doit pas dépassé 50 charactères",
                            Validator\StringLength::TOO_SHORT=>"Le nom de la formation doit contenire au moins 5 charactères",
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([

            "name"=>"semester",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Semestre ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Semestre doit être un entier"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\NumberComparison::class,
                    "options"=>[
                        "min"=>1,
                        "max"=>6,
                        "messages"=>[
                            Validator\NumberComparison::ERROR_NOT_GREATER_INCLUSIVE=>"Le semestre doit être 1 ou 2",
                            Validator\NumberComparison::ERROR_NOT_LESS_INCLUSIVE=>"Le semestre doit être 1 ou 2"
                        ]
                    ]
                ]
            ],

        ]);

        $this->add([
            "name"=>"reference",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ de référence ne doit pas être vide",
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>3,
                        "max"=>25,
                        "messages"=>[
                            Validator\StringLength::TOO_LONG=>"Le champs reference doit avoir une longeur supérieur a 25 caractères",
                            Validator\StringLength::TOO_SHORT=>"Le champs reference ne doit pas avoir une longeur inférieur a 5 caractères"
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            "name"=>"title",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Titre ne oit pzs être vide",
                        ]
                    ]
                ],
                [

                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>5,
                        "max"=>50,
                        "messages"=>[
                            Validator\StringLength::TOO_SHORT=>"Le champs titre ne doit pas avoir une longeur inférieur a 5 caractères",
                            Validator\StringLength::TOO_LONG=>"Le champs titre doit avoir une longeur su^érieur a 50 caractères",

                        ]
                    ]

                ]
            ]
        ]);

        $this->add([
            "name"=>"statut",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ statut ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>5,
                        "max"=>150,
                        "messages"=>[
                            Validator\StringLength::TOO_SHORT=>"Le champs statut ne doit pas avoir une longeur inférieur a 5 caractères",
                            Validator\StringLength::TOO_LONG=>"Le champs statut doit avoir une longeur su^érieur a 50 caractères",
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            "name"=>"hoursCm",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Heure CM ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Heure CM doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"hoursTd",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Heure TD ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Heure TD doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"hoursTp",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Heure TP ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Heure TP doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"workforce",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Effectif ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Effectif doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"grCm",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Groupe de CM ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe de CM doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"grTd",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Groupe de TD ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe de TD doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        $this->add([
            "name"=>"grTp",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Groupe de TP ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe de TP doit être un entier"
                        ]
                    ]
                ],
            ]
        ]);

        return $this;

    }


}