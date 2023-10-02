<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estado Entity
 *
 * @property int $id
 * @property int|null $cod_uf
 * @property string|null $name
 * @property string|null $uf
 * @property string|null $region
 *
 * @property \App\Model\Entity\Cidade[] $cidades
 */
class Estado extends Entity
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
        'cod_uf' => true,
        'name' => true,
        'uf' => true,
        'region' => true,
        'cidades' => true,
    ];
}
