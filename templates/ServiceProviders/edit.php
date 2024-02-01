<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ServiceProvider $serviceProvider
 */
?>
<!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header with-border">
            <h3 class="card-title"><?php echo __('Form'); ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <?php echo $this->Form->create($serviceProvider, ['role' => 'form']); ?>
          <div class="card-body">
              <fieldset>
                <legend>Dados Da Empresa</legend>
                <?php
                  echo $this->Form->control('name', ['label' => 'Nome da Empresa']);
                  echo $this->Form->control('email',  ['label' => 'Email da Empresa']);
                  echo $this->Form->control('phone',  ['label' => 'Telefone da Empresa', 'class' => 'form-control phone']);
                  echo $this->Form->control('address',  ['label' => 'Endereço da Empresa']);
                  echo $this->Form->control('address_number',  ['label' => 'Número da casa/prédio da Empresa']);
                  echo $this->Form->control('address_complement',  ['label' => 'Complemento do endereço da Empresa']);
                  echo $this->Localization->generateBasicLocation('col-md-6 col-xs-12', $serviceProvider->city, 'cities', false, 'select2bs4', $serviceProvider->state);
                  echo $this->Form->control('postal_code',  ['label' => 'CEP da Empresa', 'class' => 'form-control postal-code']);
                  echo $this->Form->control('neighborhood',  ['label' => 'Bairro da Empresa']);
                  echo $this->Form->control('active_signature');
                  echo $this->Form->control('signature_status', [
                    'type' => 'select',
                    'options' => [
                        null => 'Não Definido',
                        //'ACTIVE' => 'Ativa',
                        'CANCELLED' => 'Cancelada',
                        'TRIAL' => 'Avaliação'
                    ],
                    'empty' => '(Escolha uma opção)',  // Isso é opcional, mas é útil se você deseja adicionar um placeholder
                  ]);
                ?>
              </fieldset>

              <hr />
  
              <fieldset>
                <legend>Dados Do Serviço</legend>
                <?php
                echo $this->Form->control('services[0].id', ['value' => $serviceProvider->services[0]['id'], 'type' => 'hidden']);
                echo $this->Form->control('services[0].title', ['label' => 'Nome do Serviço', 'value' => $serviceProvider->services[0]['title']]);
                echo $this->Form->control('services[0].description', [
                  'label' => 'Descrição do Serviço',
                  'type' => 'textarea',
                  'value' => $serviceProvider->services[0]['description']
                ]);
                echo $this->Form->control('services[0].category_id', ['options' => $serviceCategories, 'default' => $serviceProvider->services[0]->category_id]);
                echo $this->Form->control('services[0].subcategory_id', ['options' => $serviceSubcategories, 'label' => 'Subcategoria', 'default' => $serviceProvider->services[0]->subcategory_id]);
                echo $this->Form->control('services[0].price', ['label' => 'Valor do Serviço', 'value' => $serviceProvider->services[0]['price'], 'class' => 'form-control price']);
                echo $this->Form->control('services[0].price_unit', ['label' => 'Unidade', 'value' => $serviceProvider->services[0]['price_unit']]);
                ?>
              </fieldset>

              <hr />
  
              <fieldset>
                <legend>Galeria de Fotos</legend>
                <div id="photo-gallery">
                </div>
                <?= $this->Form->button($this->Html->tag('i', '', ['class' => 'fa fa-upload']), [
                    'type' => 'button', 
                    'id' => 'enviar-foto', 
                    'class' => 'btn btn-info', 
                    'escapeTitle' => false
                ]) ?>


              </fieldset>

              <hr />
  
              <fieldset>
                <legend>Dados Do Usuário</legend>
                <?php
                echo $this->Form->control('users[0].id', ['value' => $serviceProvider->users[0]['id'], 'type' => 'hidden']);
                echo $this->Form->control('users[0].name', ['label' => 'Nome', 'value' => $serviceProvider->users[0]['name']]);
                echo $this->Form->control('users[0].email', ['label' => 'Email', 'value' => $serviceProvider->users[0]['email']]);
                echo $this->Form->control('users[0].cpf', ['label' => 'CPF', 'value' => $serviceProvider->users[0]['cpf'], 'class' => 'form-control cpf']);
                echo $this->Form->control('users[0].password', ['label' => 'Mudar Senha', 'value' => '']);
                echo $this->Form->control('users[0].phone', ['label' => 'Telefone', 'value' => $serviceProvider->users[0]['phone'], 'class' => 'form-control phone']);
                ?>
              </fieldset>
            </div>
            <!-- /.card-body -->

          <?php echo $this->Form->submit(__('Submit')); ?>

          <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.card -->
      </div>
  </div>
  <!-- /.row -->
</section>
<input type="file" name="field_file" id="field_file" style="display: none" accept="image/png, image/jpeg" />

<?php
$this->Html->scriptBlock("window.app_api_url='".env('APP_API_URL', false)."'", ['block' => true]);
$this->Html->scriptBlock("window.service_provider_id='".$serviceProvider->id."'", ['block' => true]);
$this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js', ['block' => true]);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js', ['block' => true]);
$this->Html->scriptBlock("
    $(document).ready(function(){
        $('.phone').mask('(00) 00000-0000');
        $('.cpf').mask('000.000.000-00');
        $('.postal-code').mask('00000-000');
        $('.price').mask('#.##0,00', {reverse: true});
    });
", ['block' => true]);

$this->Html->scriptBlock("
    $(document).ready(function(){
        $('#services-0-category-id').on('change', function(){
            var categoryId = $(this).val();
            if(categoryId) {
                $.ajax({
                    url: '/service-subcategories/options/' + categoryId + '.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#services-0-subcategory-id').empty();
                        $.each(data, function(key, value) {
                            $('#services-0-subcategory-id').append('<option value=' + key + '>' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#services-0-subcategory-id').empty();
            }
        });
    });
", ['block' => true]);
$this->Html->script('pages/ServiceProviders/edit.js', ['block' => true]);
?>
