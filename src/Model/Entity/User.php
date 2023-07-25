<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int|null $service_provider_id
 * @property string $name
 * @property string $email
 * @property string|null $cpf
 * @property string $password
 * @property string $phone
 * @property string $photo
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\ServiceProvider $service_provider
 * @property \App\Model\Entity\ChangePasswordToken[] $change_password_tokens
 * @property \App\Model\Entity\CreditCard[] $credit_cards
 * @property \App\Model\Entity\Review[] $reviews
 * @property \App\Model\Entity\ServiceProviderVisit[] $service_provider_visits
 * @property \App\Model\Entity\UserLocation[] $user_locations
 */
class User extends Entity
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
        'service_provider_id' => true,
        'name' => true,
        'email' => true,
        'cpf' => true,
        'password' => true,
        'phone' => true,
        'photo' => true,
        'created' => true,
        'modified' => true,
        'service_provider' => true,
        'change_password_tokens' => true,
        'credit_cards' => true,
        'reviews' => true,
        'service_provider_visits' => true,
        'user_locations' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];
}
