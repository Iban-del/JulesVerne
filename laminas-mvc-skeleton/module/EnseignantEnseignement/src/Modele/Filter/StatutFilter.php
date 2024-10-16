<?php

namespace EnseignantEnseignement\Modele\Filter;

use Laminas\InputFilter\InputFilter;
use Laminas\Filter;
use Laminas\Validator;

class StatutFilter extends InputFilter{

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

            "name"=>"label",
            "requered"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champs Label ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>2,
                        "max"=>25,
                        "messages"=>[
                             Validator\StringLength::TOO_SHORT=>"Le lebel doit contenir au moins 2 caracteres",
                            Validator\StringLength::TOO_LONG=>"Le lebel ne doit pas contenir plus de 25 caracteres"
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([

            "name"=>"coutCm",
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
                            Validator\NotEmpty::IS_EMPTY=>"Le champs Côut de CM ne doit pas être vide"
                        ]
                    ]
                ],
                
            ]

        ]);

        $this->add([

            "name"=>"coutTd",
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
                            Validator\NotEmpty::IS_EMPTY=>"Le champs Côut de TD ne doit pas être vide"
                        ]
                    ]
                ],
                
            ]

        ]);

        $this->add([

            "name"=>"coutTp",
            "required"=>true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToFloat::class]
                
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champs Côut de TP ne doit pas être vide"
                        ]
                    ]
                ],
                
            ]

        ]);

        return $this;

    }

}