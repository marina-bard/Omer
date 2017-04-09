<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

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

class OtherPeopleAdmin extends PersonalDataAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('team', EntityType::class, [
                'label' => 'label.team_member.team',
                'class' => BaseTeam::class,
                'multiple' => false,
            ])
        ;

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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('surname', null, [
                'label' => 'label.personal_data.surname'
            ])
            ->add('team', null, [
                'label' => 'label.other_people.team'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fullName', null, [
                'label' => 'label.personal_data.full_name',
            ])
            ->add('teamRole', null, [
                'label' => 'label.other_people.team_role'
            ])
            ->add('team', null, [
                'label' => 'label.other_people.team'
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
        $showMapper
            ->add('fullName', null, [
                'label' => 'label.personal_data.full_name',
            ])
            ->add('teamRole', null, [
                'label' => 'label.other_people.team_role'
            ])
            ->add('team', null, [
                'label' => 'label.other_people.team'
            ])
        ;
    }

    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

        if($this->getCurrentUser()->hasRole('ROLE_COACH')){
            $query
                ->innerJoin($query->getRootAlias().'.team', 't')
                ->innerJoin('t.coaches', 'c')
                ->andWhere('c.username LIKE :user')
                ->setParameter('user', $this->getCurrentUser()->getUsername());
        }

        return $query;
    }
}