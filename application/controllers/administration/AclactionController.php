<?php
/*
 * Copyright 2005-2014 MERETHIS
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation ; either version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 *
 * Linking this program statically or dynamically with other modules is making a
 * combined work based on this program. Thus, the terms and conditions of the GNU
 * General Public License cover the whole combination.
 *
 * As a special exception, the copyright holders of this program give MERETHIS
 * permission to link this program with independent modules to produce an executable,
 * regardless of the license terms of these independent modules, and to copy and
 * distribute the resulting executable under terms of MERETHIS choice, provided that
 * MERETHIS also meet, for each linked independent module, the terms  and conditions
 * of the license of that module. An independent module is a module which is not
 * derived from this program. If you modify this program, you may extend this
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 *
 * For more information : contact@centreon.com
 *
 */

namespace Controllers\Administration;

use \Centreon\Core\Form;
use \Centreon\Core\Form\Generator;

class AclactionController extends \Controllers\ObjectAbstract
{
    protected $objectDisplayName = 'AclAction';
    protected $objectName = 'aclaction';
    protected $objectBaseUrl = '/administration/aclaction';
    protected $objectClass = '\Models\Configuration\Acl\Action';
    public static $relationMap = array(
        'aclaction_aclgroups' => '\Models\Configuration\Relation\Aclgroup\Aclaction'
    );

    /**
     * List aclaction
     *
     * @method get
     * @route /administration/aclaction
     */
    public function listAction()
    {
        parent::listAction();
    }

    /**
     * 
     * @method get
     * @route /administration/aclaction/list
     */
    public function datatableAction()
    {
        parent::datatableAction();
    }
    
    /**
     * Create a new acl action
     *
     * @method post
     * @route /administration/aclaction/create
     */
    public function createAction()
    {
        parent::createAction();
    }

    /**
     * Update an acl action
     *
     *
     * @method post
     * @route /administration/aclaction/update
     */
    public function updateAction()
    {
        parent::updateAction();
    }
    
    /**
     * Add a aclaction
     *
     *
     * @method get
     * @route /administration/aclaction/add
     */
    public function addAction()
    {
        // Init template
        $di = \Centreon\Core\Di::getDefault();
        $tpl = $di->get('template');
        
        $form = new Form('aclactionForm');
        $form->addText('name', _('Name'));
        $form->addText('description', _('Description'));
        
        $radios['list'] = array(
          array(
              'name' => 'Enabled',
              'label' => 'Enabled',
              'value' => '1'
          ),
          array(
              'name' => 'Disabled',
              'label' => 'Disabled',
              'value' => '0'
          )
        );
        $form->addRadio('enabled', _("Status"), 'status', '&nbsp;', $radios);
        
        $form->add('save_form', 'submit', _("Save"), array("onClick" => "validForm();"));
        $tpl->assign('form', $form->toSmarty());
        
        // Display page
        $tpl->display('administration/aclaction/edit.tpl');
    }
    
    /**
     * Update a aclaction
     *
     *
     * @method get
     * @route /administration/aclaction/[i:id]
     */
    public function editAction()
    {
        parent::editAction();
    }

    /**
     * Retrieve list of acl action for a form
     *
     * @method get
     * @route /administration/aclaction/formlist
     */
    public function formListAction()
    {
        parent::formListAction();
    }

    /**
     * Get default list of Acl groups
     *
     * @method get
     * @route /administration/aclaction/[i:id]/aclgroup
     */
    public function aclgroupAction()
    {
        parent::getRelations($this->relationMap['aclaction_aclgroups']);
    }
}
