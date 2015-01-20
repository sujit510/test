<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'departmentId'); ?>
		<?php // echo $form->textField($model,'departmentId'); ?>
            <?php echo $form->dropDownList($model,'departmentId', CHtml::listData(Department::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'departmentId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'firstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastName'); ?>
		<?php echo $form->textField($model,'lastName',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'lastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ext'); ?>
		<?php echo $form->textField($model,'ext'); ?>
		<?php echo $form->error($model,'ext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hireDate'); ?>
		<?php echo $form->textField($model,'hireDate'); ?>
		<?php echo $form->error($model,'hireDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'leaveDate'); ?>
		<?php echo $form->textField($model,'leaveDate'); ?>
		<?php echo $form->error($model,'leaveDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->