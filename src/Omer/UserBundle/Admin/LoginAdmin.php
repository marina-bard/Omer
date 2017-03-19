<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 19.03.17
 * Time: 21:15
 */

namespace Omer\UserBundle\Admin;

use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected $baseRouteName = 'admin_omer_user_login';

    protected $baseRoutePattern = 'omer/user/login';

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getSubject()->hasRole('ROLE_SUPER_ADMIN')
            || $this->getSubject()->hasRole('ROLE_MAIN_ADMIN')
        ) {
            $formMapper
                ->add('username', TextType::class);
        }
        else {
            $formMapper
                ->add('email', EmailType::class);
        }

        $formMapper
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getCurrentUser()->hasRole('ROLE_SUPER_ADMIN')) {
            $query
                ->andWhere($query->getRootAlias().'.email = :email')
                ->setParameter('email', $this->getCurrentUser()->getEmail())
            ;
        }

        return $query;
    }

    public function preUpdate($object) {
        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $um->updateCanonicalFields($object);
        $um->updatePassword($object);
    }

}