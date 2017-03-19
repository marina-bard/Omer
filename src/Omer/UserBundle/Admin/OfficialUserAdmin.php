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
use Omer\UserBundle\Entity\OfficialUser;
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
        if (!$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')
            || !$this->getSubject()->hasRole('ROLE_MAIN_ADMIN')
        ) {
            $formMapper
                ->add('roles', ChoiceType::class, [
                    'choices' => OfficialUser::ROLES,
                    'multiple' => true,
                    'translation_domain' => 'OmerUserBundle',
                    'attr' => ['readonly' => true]
                ])
                ->add('firstName', TextType::class, [
                    'label' => 'label.personal_data.first_name',
                    'translation_domain' => 'OmerUserBundle'
                ])
                ->add('surname', TextType::class, [
                    'label' => 'label.personal_data.surname',
                    'translation_domain' => 'OmerUserBundle'
                ])
                ->add('gender', ChoiceType::class, [
                    'choices' => array_flip(OfficialUser::GENDER),
                    'label' => 'label.user.gender',
                    'translation_domain' => 'OmerUserBundle',
                ])
                ->add('T_shirtSize', TextType::class, [
                    'label' => 'label.personal_data.t_shirt_size',
                    'translation_domain' => 'OmerUserBundle'
                ])
                ->add('association', TextType::class, [
                    'label' => 'label.user.association'
                ])
                ->add('citizenship', TextType::class, [
                    'label' => 'label.personal_data.citizenship',
                    'translation_domain' => 'OmerUserBundle'
                ])
                ->add('address', TextType::class, [
                    'label' => 'label.other_people.address'
                ])
                ->add('dateOfBirth', 'sonata_type_date_picker', [
                    'format' => 'dd.MM.yyyy',
                    'dp_view_mode' => 'years',
                    'label' => 'label.personal_data.date_of_birth',
                    'translation_domain' => 'OmerUserBundle',
                    'attr' => ['readonly' => true]
                ])
                ->add('passportNumber', TextType::class, [
                    'label' => 'label.personal_data.passport_number',
                    'translation_domain' => 'OmerUserBundle'
                ])
                ->add('dateOfIssue', 'sonata_type_date_picker', [
                    'format' => 'dd.MM.yyyy',
                    'dp_view_mode' => 'years',
                    'label' => 'label.personal_data.date_of_issue',
                    'translation_domain' => 'OmerUserBundle',
                    'attr' => ['readonly' => true]
                ])
                ->add('dateOfExpiry', 'sonata_type_date_picker', [
                    'format' => 'dd.MM.yyyy',
                    'dp_view_mode' => 'years',
                    'label' => 'label.personal_data.date_of_expiry',
                    'translation_domain' => 'OmerUserBundle',
                    'attr' => ['readonly' => true]
                ])
                ->add('mobilePhone', TextType::class, [
                    'label' => 'label.user.mobile_phone',
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
            ->add('association', null,[
                'label' => 'label.user.association'
            ])
            ->add('surname', null, [
                'label' => 'label.personal_data.surname'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        dump($this->getBaseRouteName());
        dump($this->getBaseRoutePattern());
        $listMapper
            ->add('fullName', null,[
                'label' => 'label.personal_data.full_name'
            ])
            ->add('email', null, [
                'label' => 'label.coach_user.email',
                'translation_domain' => 'OmerUserBundle'
            ])
            ->add('association', null,[
                'label' => 'label.user.association'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    // add query for role director and judge

    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

        if ($this->getCurrentUser()->hasRole('ROLE_MAIN_ADMIN')) {
            $query
                ->andWhere($query->getRootAlias().'.roles NOT LIKE :role')
                ->setParameter('role', '%ROLE_SUPER_ADMIN%')
            ;
        }
        elseif (!$this->getCurrentUser()->hasRole('ROLE_SUPER_ADMIN')) {
            $query
                ->andWhere($query->getRootAlias().'.email = :email')
                ->setParameter('email', $this->getCurrentUser()->getEmail())
            ;
        }

        return $query;
    }

    public function prePersist($object){
        if (!$this->getCurrentUser()->hasRole('ROLE_SUPER_ADMIN')
            || !$this->getCurrentUser()->hasRole('ROLE_MAIN_ADMIN')
        ) {
            $object->setUsername($object->getEmail());
        }
    }
}