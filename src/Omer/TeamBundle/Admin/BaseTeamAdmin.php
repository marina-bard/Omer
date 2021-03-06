<?php

/**
 * Created by PhpStorm.
 * User: marina
 * Date: 26.01.17
 * Time: 22:37
 */

namespace Omer\TeamBundle\Admin;

use Omer\UserBundle\Traits\CurrentUserTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BaseTeamAdmin extends AbstractAdmin
{
    use CurrentUserTrait;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('englishTeamName', TextType::class, [
                'label' => 'label.team.english_team_name'
            ])
            ->add('memberNumber', NumberType::class, [
                'label' => 'label.team.member_number'
            ])
            ->add('country', TextType::class, [
                'label' => 'label.team.country'
            ])
            ->add('district', TextType::class, [
                'label' => 'label.team.district'
            ])
            ->add('city', TextType::class, [
                'label' => 'label.team.city'
            ])
            ->add('coaches', 'sonata_type_model', [
                'label' => 'coaches',
                'property' => 'full_name',
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('members', 'sonata_type_model', [
                'label' => 'label.team.members',
                'property' => 'full_name',
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('otherPeople', 'sonata_type_model', [
                'label' => 'label.team.other_people',
                'property' => 'full_name',
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('englishTeamName', null, [
                'label' => 'label.team.english_team_name'
            ])
            ->add('problem', null, [
                'label' => 'label.team.problem'
            ])
            ->add('division', null, [
                'label' => 'label.team.problem'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('englishTeamName', null, [
                'label' => 'label.team.english_team_name'
            ])
            ->add('memberNumber', null, [
                'label' => 'label.team.member_number'
            ])
            ->add('country', null, [
                'label' => 'label.team.country'
            ])
            ->add('city', null, [
                'label' => 'label.team.city'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'download_excel' => [
                        'template' => 'OmerTeamBundle:CRUD:list__action_download_team_excel.html.twig'
                    ]
                )
            ))
        ;
    }

    public function createQuery($context = 'list')
    {
        /**
         * @var ProxyQuery $query
         */
        $query = parent::createQuery($context);

        if($this->getCurrentUser()->hasRole('ROLE_COACH')) {
            $query
                ->innerJoin($query->getRootAlias().'.coaches', 'c')
                ->innerJoin('c.teams', 't')
                ->andWhere('c.username LIKE :user')
                ->setParameter('user', $this->getCurrentUser()->getUsername());
        }

        return $query;
    }

    public function preUpdate($team)
    {
        $team->setMembers($team->getMembers());
        $team->setOtherPeople($team->getOtherPeople());
    }

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('add');

        $collection->add('download_excel', $this->getRouterIdParameter() . '/download_excel');
    }
}