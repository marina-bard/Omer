<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 19.03.17
 * Time: 2:55
 */

namespace Omer\UserBundle\Admin;

use Omer\TeamBundle\Entity\BaseTeam;
use Omer\UserBundle\Admin\PersonalDataAdmin;
use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Email;

class OfficialUserAdmin extends PersonalDataAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getCurrentUser()->hasRole('ROLE_SUPER_ADMIN')
            || $this->getCurrentUser()->hasRole('ROLE_MAIN_ADMIN')
        ) {
            $formMapper
                ->add('username', TextType::class)
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch'));
            ;
        }
        else {
            parent::configureFormFields($formMapper);

            $formMapper
                ->add('teamRole', TextType::class, [
                    'label' => 'label.other_people.team_role'
                ])
                ->add('address', TextType::class, [
                    'label' => 'label.other_people.address'
                ])
                ->add('email', EmailType::class, [
                    'label' => 'label.other_people.email'
                ])
                ->add('dietaryConcerns', TextareaType::class, [
                    'label' => 'label.dietary_concerns',
                    'required' => false
                ])
                ->add('medicalConcerns', TextareaType::class, [
                    'label' => 'label.medical_concerns',
                    'required' => false
                ])
            ;
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('surname', null, [
                'label' => 'label.other_name.surname'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('email', null, [
                'label' => 'label.coach_user.email',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
    }

    // add query for role director and judge


    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

//        if ($this->getCurrentUser()->hasRole('ROLE_MAIN_ADMIN')) {
//            $query
//                ->andWhere($query->getRootAlias().'.roles LIKE \'%ROLE_SONATA_ADMIN%\'');
//        }

        return $query;
    }

    public function prePersist($object){
        if (!$this->getCurrentUser()->hasRole('ROLE_SUPER_ADMIN')
            || !$this->getCurrentUser()->hasRole('ROLE_MAIN_ADMIN')
        ) {
            $object->setUsername($object->getEmail());
        }
    }

    public function preUpdate($object) {
        $um = $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager');
        $um->updateCanonicalFields($object);
        $um->updatePassword($object);
    }
}