<?php

/**
 * @file
 * API documentation for Smartdocs module.
 */

/**
 * Allows a module to take some action immediately after a SmartDocs model
 * or one of its child objects (revision, resource, method) has been created,
 * updated or deleted.
 *
 * @param string $model_uuid
 *    The unique identifier for the model being updated.
 */
function hook_smartdocs_model_update($model_uuid) {
  drupal_set_message('Model ' . $model_uuid . ' has just been updated.');
}

/**
 * Allows a module to alter the rendered output of a SmartDocs node right
 * before it is cached and served.
 *
 * @param string $content
 *    The rendered HTML output for the SmartDocs method.
 * @param \stdClass $node
 *    The SmartDocs method node which is being rendered.
 */
function hook_smartdocs_model_alter(&$content, stdClass $node) {
  $content = str_replace('%node-title%', $node->title, $content);
}

/**
 * Act before method would be saved.
 *
 * @param \Apigee\SmartDocs\Method $method_obj
 *   Method that is going to be saved.
 * @param string $model_name
 *   Name of the model, which this method belongs to.
 * @param int $revision_uuid
 *   UUID of the affected revision.
 * @param string $resource_uuid
 *   UUID of the affected resource.
 * @param bool $is_update
 *   Tell us whether it is an update or a create.
 */
function hook_smartdocs_method_presave(\Apigee\SmartDocs\Method $method_obj, $model_name, $revision_uuid, $resource_uuid, $is_update) {
  watchdog(__FUNCTION__, '"@method" method is going to be @action.', array('@method' => $method_obj->getDisplayName(), '@action' => $is_update ? t('updated') : t('created')), WATCHDOG_INFO);
}

/**
 * Act after method has been saved.
 *
 * @param \Apigee\SmartDocs\Method $method_obj
 *   Method that has been saved.
 * @param string $model_name
 *   Name of the model, which this method belongs to.
 * @param int $revision_uuid
 *   UUID of the affected revision.
 * @param string $resource_uuid
 *   UUID of the affected resource.
 * @param bool $is_update
 *   Tell us whether it is an update or a create.
 */
function hook_smartdocs_method_postsave(\Apigee\SmartDocs\Method $method_obj, $model_name, $revision_uuid, $resource_uuid, $is_update) {
  watchdog(__FUNCTION__, '"@method" method is @action.', array('@method' => $method_obj->getDisplayName(), '@action' => $is_update ? t('updated') : t('created')), WATCHDOG_INFO);
}

/**
 * Act before method would be deleted.
 *
 * @param \Apigee\SmartDocs\Method $method
 *   Method, which is going to be deleted.
 * @param string $model_uuid
 *   UUID of the affected model, which the affected method belongs to.
 * @param string $revision_uuid
 *   UUID of the affected revision.
 * @param string $resource_uuid
 *   UUID of the affected resource.
 */
function hook_smartdocs_method_predelete(\Apigee\SmartDocs\Method $method, $model_uuid, $revision_uuid, $resource_uuid) {
}

/**
 * Act after method has been deleted.
 *
 * @param \Apigee\SmartDocs\Method $method
 *   Method that has just been deleted.
 * @param string $model_uuid
 *   UUID of the model, which the affected method belonged to.
 * @param string $revision_uuid
 *   UUID of the affected revision.
 * @param string $resource_uuid
 *   UUID of the affected resource.
 */
function hook_smartdocs_method_postdelete(\Apigee\SmartDocs\Method $method, $model_uuid, $revision_uuid, $resource_uuid) {
}

/**
 * Act before Smartdocs method node would be saved.
 *
 * @param \stdClass $node
 *   Smartdocs method node object, which is going to be saved.
 * @param array $model
 *   Model, which the method belongs to.
 * @param array $revision
 *   Revision of the model, which the method belongs to.
 * @param array $resource
 *   Resource, which the method belongs to.
 * @param array $method
 *   Method from which node has been rendered.
 */
function hook_smartdocs_method_node_presave(stdClass $node, array $model, array $revision, array $resource, array $method) {
  $node->title = $model['displayName'] . ': ' . $node->title;
}

/**
 * Act after Smartdocs method node has been saved.
 *
 * @param \stdClass $node
 *   Smartdocs method node object, which has just been saved.
 * @param array $model
 *   Model, which the method belongs to.
 * @param array $revision
 *   Revision of the model, which the method belongs to.
 * @param array $resource
 *   Resource, which the method belongs to.
 * @param array $method
 *   Method from which node has been rendered.
 */
function hook_smartdocs_method_node_postsave(stdClass $node, array $model, array $revision, array $resource, array $method) {
  $node->title = $model['displayName'] . ': ' . $node->title;
}

/**
 * Act before an "action" would be taken on a method node.
 *
 * @param \Apigee\SmartDocs\Method $method
 *   Method, which the affected method node belongs to.
 * @param int $nid
 *   Nid of the affected method node.
 * @param string $model_uuid
 *   UUID of the model, which the affected method belongs to.
 * @param string $revision_uuid
 *   UUID of the revision, which the affected method belongs to.
 * @param string $resource_uuid
 *   UUID of the resource, which the affected method belongs to.
 * @param string $action
 *   One from: delete, keep, unpublish.
 *
 * @see smartdocs_method_delete()
 */
function hook_smartdocs_method_node_preaction(\Apigee\SmartDocs\Method $method, $nid, $model_uuid, $revision_uuid, $resource_uuid, $action) {
}

/**
 * Act after an "action" has been taken on a method node.
 *
 * @param \Apigee\SmartDocs\Method $method
 *   Method, which the affected method node belongs to.
 * @param int $nid
 *   Nid of the affected method node.
 * @param string $model_uuid
 *   UUID of the model, which the affected method belongs to.
 * @param string $revision_uuid
 *   UUID of the revision, which the affected method belongs to.
 * @param string $resource_uuid
 *   UUID of the resource, which the affected method belongs to.
 * @param string $action
 *   One from: delete, keep, unpublish.
 *
 * @see smartdocs_method_delete()
 */
function hook_smartdocs_method_node_postaction(\Apigee\SmartDocs\Method $method, $nid, $model_uuid, $revision_uuid, $resource_uuid, $action) {
}

/**
 * Act before method node would be deleted.
 *
 * Shortened form of hook_smartdocs_method_node_preaction() with 'delete' as
 * $action parameter.
 *
 * @param string $method_uuid
 *   UUID if the method, which the affected method node belonged to.
 * @param int $nid
 *   Nid of the method node which is going to be deleted.
 * @param string $model_uuid
 *   UUID of the model, which the affected method belongs to.
 * @param string $revision_uuid
 *   UUID of the revision, which the affected method belongs to.
 * @param string $resource_uuid
 *   UUID of the resource, which the affected method belongs to.
 */
function hook_smartdocs_method_node_predelete($method_uuid, $nid, $model_uuid, $revision_uuid, $resource_uuid) {
}

/**
 * Act after method node deleted.
 *
 * Shortened form of hook_smartdocs_method_node_postaction() with 'delete' as
 * $action parameter.
 *
 * @param string $method_uuid
 *   UUID if the method, which the affected method node belonged to.
 * @param int $nid
 *   Nid of the deleted method node.
 * @param string $model_uuid
 *   UUID of the model, which the affected method belonged to.
 * @param string $revision_uuid
 *   UUID of the revision, which the affected method belonged to.
 * @param string $resource_uuid
 *   UUID of the resource, which the affected method belonged to.
 */
function hook_smartdocs_method_node_postdelete($method_uuid, $nid, $model_uuid, $revision_uuid, $resource_uuid) {
}

/**
 * Act before a model would be saved.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Model which is going to be saved.
 */
function hook_smartdocs_model_presave(\Apigee\SmartDocs\Model $model) {
  $model->setDisplayName('Demo: ' . $model->getDisplayName());
}

/**
 * Act after a model has been saved.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Model that has just been saved.
 */
function hook_smartdocs_model_postsave(\Apigee\SmartDocs\Model $model) {
  watchdog(__FUNCTION__, '"@model" model is successfully saved.', array('@model' => $model->getDisplayName()), WATCHDOG_INFO);
}

/**
 * Act before a model would be deleted.
 *
 * @param string $model_name
 *   Model which is going to be deleted.
 */
function smartdocs_model_predelete($model_name) {
  watchdog(__FUNCTION__, '@model is going to be deleted.', array('@model' => $model_name), WATCHDOG_INFO);
}

/**
 * Act after a model has been deleted.
 *
 * @param string $model_name
 *   Model that has just been deleted.
 */
function smartdocs_model_postdelete($model_name) {
  watchdog(__FUNCTION__, '@model is deleted.', array('@model' => $model_name), WATCHDOG_INFO);
}

/**
 * Act before a model's template would be saved.
 *
 * @param string $model_name
 *   Name of the affected model.
 * @param string $template_content
 *   Raw template content.
 */
function hook_smartdocs_template_presave($model_name, $template_content) {
  $template_content .= '<p><strong>Powered by Apigee!</strong></p>';
}

/**
 * Act after a model's template has been saved.
 *
 * @param string $model_name
 *   Name of the model affected model.
 * @param string $template_content
 *   Raw template content.
 */
function hook_smartdocs_template_postsave($model_name, $template_content) {
  watchdog(__FUNCTION__, "Model's (@model) template successfully updated.", array('@model' => $model_name), WATCHDOG_INFO);
}

/**
 * Act after a model's template reverted.
 *
 * @param string $model_name
 *   Name of the model affected model.
 */
function hook_smartdocs_template_reverted($model_name) {
  watchdog(__FUNCTION__, "Model's (@model) template successfully reverted.", array('@model' => $model_name), WATCHDOG_INFO);
}

/**
 * Act after a model successfully imported from a source.
 *
 * @param string $file_contents
 *   Raw content from the source.
 * @param string $content_type
 *   Content type of the file content. One from:  application/{json, xml, yml}.
 * @param string $document_format
 *   Document format of the file content. One from: apimodel, swagger, wadl.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param string $source
 *   Either "url" or "file".
 */
function hook_smartdocs_model_import($file_contents, $content_type, $document_format, \Apigee\SmartDocs\Model $model, $source) {
}

/**
 * Act before resources would be imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Resource[] $resource_enums
 *   Array of resources which are going to be imported.
 */
function hook_smartdocs_import_revision_resources_presave(\Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, array $resource_enums) {
}

/**
 * Act after resources have been imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Resource[] $resource_enums
 *   Array of resources which have been imported.
 */
function hook_smartdocs_import_revision_resources_postsave(\Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, array $resource_enums) {
}

/**
 * Act before methods would be imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Method[] $method_enums
 *   Array of methods which are going to be imported.
 */
function hook_smartdocs_import_revision_methods_presave(\Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, array $method_enums) {
}

/**
 * Act after methods have been imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Method[] $method_enums
 *   Array of methods which have been imported.
 */
function hook_smartdocs_import_revision_methods_postsave(\Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, array $method_enums) {
}

/**
 * Act before a resource would be imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Resource $resource
 *   Resource which is going to be imported.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param bool $is_update
 *   Tell us whether it is an update or a create.
 */
function hook_smartdocs_resource_presave(\Apigee\SmartDocs\Resource $resource, \Apigee\SmartDocs\Revision $revision, \Apigee\SmartDocs\Model $model, $is_update) {
}

/**
 * Act after a resource imported to a model's revision.
 *
 * @param \Apigee\SmartDocs\Resource $resource
 *   Resource which has just been imported.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 * @param bool $is_update
 *   Tell us whether it was an update or a create.
 */
function hook_smartdocs_resource_postsave(\Apigee\SmartDocs\Resource $resource, \Apigee\SmartDocs\Revision $revision, \Apigee\SmartDocs\Model $model, $is_update) {
}

/**
 * Act before a resource would be deleted.
 *
 * @param \Apigee\SmartDocs\Resource $resource
 *   Resource which is going to be deleted.
 * @param string $revision_uuid
 *   UUID of the revision which this resource belonged to.
 * @param string $model_name
 *   Name of the model, which this revision and resource belonged to.
 */
function hook_smartdocs_resource_predelete(\Apigee\SmartDocs\Resource $resource, $revision_uuid, $model_name) {
}

/**
 * Act after a resource has been deleted.
 *
 * @param \Apigee\SmartDocs\Resource $resource
 *   Resource that has just been deleted.
 * @param string $revision_uuid
 *   UUID of the revision which this resource belonged to.
 * @param string $model_name
 *   Name of the model, which this revision and resource belonged to.
 */
function hook_smartdocs_resource_postdelete(\Apigee\SmartDocs\Resource $resource, $revision_uuid, $model_name) {
}

/**
 * Act before a template authentication scheme would be saved.
 *
 * @param \Apigee\SmartDocs\TemplateAuth $template_auth
 *   Affected template auth.
 * @param \Apigee\SmartDocs\Security\TemplateAuthScheme $scheme
 *   Scheme, which is going to be saved.
 * @param string $model_uuid
 *   UUID of the affected model, which the affected template auth. belongs to.
 * @param bool $is_update
 *   Tell us whether it is an update or a create.
 */
function hook_smartdocs_template_auth_scheme_presave(\Apigee\SmartDocs\TemplateAuth $template_auth, \Apigee\SmartDocs\Security\TemplateAuthScheme $scheme, $model_uuid, $is_update) {
}

/**
 * Act after a template authentication scheme has been saved.
 *
 * @param \Apigee\SmartDocs\TemplateAuth $template_auth
 *   Affected template auth.
 * @param \Apigee\SmartDocs\Security\TemplateAuthScheme $scheme
 *   Scheme, which has been saved.
 * @param string $model_uuid
 *   UUID of the affected model, which the affected template auth. belongs to.
 * @param bool $is_update
 *   Tell us whether it was an update or a create.
 */
function hook_smartdocs_template_auth_scheme_postsave(\Apigee\SmartDocs\TemplateAuth $template_auth, \Apigee\SmartDocs\Security\TemplateAuthScheme $scheme, $model_uuid, $is_update) {
}

/**
 * Act before a template authentication scheme would be deleted.
 *
 * @param string $scheme_name
 *   Name of the scheme, which is going to be deleted.
 * @param string $model_uuid
 *   UUID of the model, which this security scheme belongs to.
 */
function hook_smartdocs_template_auth_scheme_predelete($scheme_name, $model_uuid) {
}

/**
 * Act after a template authentication has been deleted.
 *
 * @param string $scheme_name
 *   Name of the scheme that has been deleted.
 * @param string $model_uuid
 *   UUID of the model, which this security scheme belonged to.
 */
function hook_smartdocs_template_auth_scheme_postdelete($scheme_name, $model_uuid) {
}

/**
 * Act before a security scheme would be saved.
 *
 * @param \Apigee\SmartDocs\Security\SecurityScheme $scheme
 *   Security scheme, which is going to be saved.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model, which this security scheme made for.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param bool $is_update
 *   Tell us whether it is an update or a create.
 */
function hook_smartdocs_model_security_scheme_presave(\Apigee\SmartDocs\Security\SecurityScheme $scheme, \Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, $is_update) {
}

/**
 * Act after a security scheme has been saved.
 *
 * @param \Apigee\SmartDocs\Security\SecurityScheme $scheme
 *   Security scheme that just been saved.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model, which this security scheme belongs to.
 * @param \Apigee\SmartDocs\Revision $revision
 *   Affected revision of the model.
 * @param bool $is_update
 *   Tell us whether it was an update or a create.
 */
function hook_smartdocs_model_security_scheme_postsave(\Apigee\SmartDocs\Security\SecurityScheme $scheme, \Apigee\SmartDocs\Model $model, \Apigee\SmartDocs\Revision $revision, $is_update) {
}

/**
 * Act before a security scheme would be deleted.
 *
 * @param \Apigee\SmartDocs\Security\SecurityScheme $scheme
 *   Security scheme, which is going to be deleted.
 * @param string $model_uuid
 *   UUID of the model, which this security scheme belongs to.
 * @param string $revision_uuid
 *   UUID of the affected revision of the model.
 */
function hook_smartdocs_security_predelete(\Apigee\SmartDocs\Security\SecurityScheme $scheme, $model_uuid, $revision_uuid) {
}

/**
 * Act after a security scheme has been deleted.
 *
 * @param \Apigee\SmartDocs\Security\SecurityScheme $scheme
 *   Security scheme that has just been deleted.
 * @param string $model_uuid
 *   UUID of the model, which this security scheme belongs to.
 * @param string $revision_uuid
 *   UUID of the affected revision of the model.
 */
function hook_smartdocs_security_postdelete(\Apigee\SmartDocs\Security\SecurityScheme $scheme, $model_uuid, $revision_uuid) {
}

/**
 * Act before a model revision would be saved.
 *
 * @param \Apigee\SmartDocs\Revision $revision
 *   Revision of the model.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 */
function hook_smartdocs_revision_presave(\Apigee\SmartDocs\Revision $revision, \Apigee\SmartDocs\Model $model) {
}

/**
 * Act after a model revision has been saved.
 *
 * @param \Apigee\SmartDocs\Revision $revision
 *   Revision of the model that has just been saved.
 * @param \Apigee\SmartDocs\Model $model
 *   Affected model.
 */
function hook_smartdocs_revision_postsave(\Apigee\SmartDocs\Revision $revision, \Apigee\SmartDocs\Model $model) {
}
