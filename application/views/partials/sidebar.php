<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		</div>
		<div class="sidebar-brand-text mx-3">CHASIER</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item <?= $aktif == 'dashboard' ? 'active' : '' ?>">
		<a class="nav-link" href="<?= base_url('dashboard') ?>">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Dashboard</span></a>
	</li>

	<?php if ($this->session->userdata('role_id') == 3) : ?>
		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			KASIR
		</div>

		<li class="nav-item <?= $aktif == 'pesan' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('pesan') ?>">
				<i class="fas fa-fw fa-shopping-cart"></i>
				<span>Pesan</span></a>
		</li>

		<li class="nav-item <?= $aktif == 'transaksi_saya' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('transaksi') ?>">
				<i class="fas fa-fw fa-file-invoice"></i>
				<span>Transaksi</span></a>
		</li>
	<?php endif; ?>

	<?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			MANAGEMENT MENU / BARANG
		</div>

		<li class="nav-item <?= $aktif == 'barang' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('barang') ?>">
				<i class="fas fa-fw fa-box"></i>
				<span>Daftar Menu</span></a>
		</li>

		<!-- <li class="nav-item <?= $aktif == 'kasir' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('kasir') ?>">
				<i class="fas fa-fw fa-cash-register"></i>
				<span>Master Kasir</span></a>
		</li> -->
	<?php endif; ?>

	<?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			LAPORAN
		</div>

		<li class="nav-item <?= $aktif == 'transaksi' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('transaksi') ?>">
				<i class="fas fa-fw fa-file-invoice"></i>
				<span>Transaksi Pembelian </span></a>
		</li>

		<li class="nav-item <?= $aktif == 'laporan' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('laporan') ?>">
				<i class="fas fa-fw fa-file-invoice"></i>
				<span>Pendapatan</span></a>
		</li>

		<li class="nav-item <?= $aktif == 'aktivitas' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('aktivitas') ?>">
				<i class="fas fa-fw fa-file-invoice"></i>
				<span>Aktivitas</span></a>
		</li>
	<?php endif; ?>

	<?php if ($this->session->userdata('role_id') == 1) : ?>
		<hr class="sidebar-divider">
		<!-- Heading -->
		<div class="sidebar-heading">
			Pengaturan
		</div>

		<li class="nav-item <?= $aktif == 'pegawai' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('pegawai') ?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Manajemen Pegawai</span></a>
		</li>

		<li class="nav-item <?= $aktif == 'toko' ? 'active' : '' ?>">
			<a class="nav-link" href="<?= base_url('toko') ?>">
				<i class="fas fa-fw fa-building"></i>
				<span>Profil Toko</span></a>
		</li>
	<?php endif; ?>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>