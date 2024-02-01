<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item <?php echo $this->getRequest()->getParam('controller') === 'Pages' && $this->getRequest()->getParam('action') === 'display' ? 'menu-open' : ''; ?>">
      <a href="<?php echo $this->Url->build('/'); ?>" class="nav-link">
        <p>Página Inicial</p>
      </a>
    </li>

    <li class="nav-item <?php echo $this->getRequest()->getParam('controller') === 'ServiceCategories' ? 'menu-open' : ''; ?>">
      <a href="<?php echo $this->Url->build('/service-categories'); ?>" class="nav-link">
        <p>Categorias</p>
      </a>
    </li>

    <li class="nav-item <?php echo $this->getRequest()->getParam('controller') === 'ServiceSubcategories' ? 'menu-open' : ''; ?>">
      <a href="<?php echo $this->Url->build('/service-subcategories'); ?>" class="nav-link">
        <p>Sub Categorias</p>
      </a>
    </li>

    <li class="nav-item <?php echo $this->getRequest()->getParam('controller') === 'ServiceProviders' ? 'menu-open' : ''; ?>">
      <a href="<?php echo $this->Url->build('/service-providers'); ?>" class="nav-link">
        <p>Prestadores de Serviços</p>
      </a>
    </li>

    <li class="nav-item <?php echo $this->getRequest()->getParam('controller') === 'Users' ? 'menu-open' : ''; ?>">
      <a href="<?php echo $this->Url->build('/users'); ?>" class="nav-link">
        <p>Usuários</p>
      </a>
    </li>

    <!-- Outros itens do menu aqui -->

  </ul>
</nav>
