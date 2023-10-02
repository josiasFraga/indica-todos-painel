<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cidade Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $uf
 * @property int|null $cod_municipio
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Estado $estado
 */
class Cidade extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'uf' => true,
        'cod_municipio' => true,
        'estado_id' => true,
        'estado' => true,
    ];
}
