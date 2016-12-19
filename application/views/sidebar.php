<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<!--form role="search">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</form-->
	<ul class="nav menu">
		<li class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/dashboard') ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>

		<?php if ($role == '0') { ?>
		
		<li class="<?php echo (($this->uri->segment(2) == 'pengguna') || ($this->uri->segment(2) == 'penggunaTambah') || ($this->uri->segment(2) == 'penggunaEdit') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/pengguna') ?>"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Manajemen Pengguna</a></li>
		<li class="<?php echo (($this->uri->segment(2) == 'kriteria') || ($this->uri->segment(2) == 'kriteriaTambah') || ($this->uri->segment(2) == 'kriteriaEdit') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/kriteria') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Manajemen Kriteria</a></li>
		<li class="<?php echo (($this->uri->segment(2) == 'parameter') || ($this->uri->segment(2) == 'parameterTambah') || ($this->uri->segment(2) == 'parameterEdit') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/parameter') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Manajemen Sub Kriteria</a></li>
		<li class="<?php echo (($this->uri->segment(2) == 'alternatifKaryawan') || ($this->uri->segment(2) == 'alternatifKaryawanTambah') || ($this->uri->segment(2) == 'alternatifKaryawanEdit') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/alternatifKaryawan') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Manajemen Alternatif</a></li>
		<li class="<?php echo ( ($this->uri->segment(2) == 'dataKaryawan') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('home/dataKaryawan') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Data Karyawan</a></li>		
		<li class="<?php echo (($this->uri->segment(1) == 'nilai') || ($this->uri->segment(2) == 'alternatifKaryawanTambah') || ($this->uri->segment(2) == 'alternatifKaryawanEdit') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('nilai/nilaiAlternatif') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Manajemen Nilai</a></li>	
		<li class="<?php echo (($this->uri->segment(1) == 'dm') ) ? 'active' : '' ; ?>"><a href="<?php echo site_url('dm/pembobotan') ?>"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-calendar"></use></svg> Pembobotan DM</a></li>	
		<?php } ?>		

		<li class="parent <?php echo ($this->uri->segment(2) == 'kompetensiRev' || $this->uri->segment(2) == 'manajemen') ? 'active' : '' ?>">
			<a href="#">
				<span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Pembobotan Kriteria
			</a>
			<ul class="children collapse" id="sub-item-1">
				<?php if ($role == '0' || $role == '2') { ?>
				<li>
					<a class="" href="<?php echo site_url('kriteria/kompetensiRev') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kriteria Kompetensi
					</a>
				</li>
				<?php }else{ ?>				
				<li>
					<a class="" href="<?php echo site_url('kriteria/manajemenRev') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kriteria Manajemen
					</a>
				</li>		
				<?php } ?>		
			</ul>
		</li>
		
		<?php if ($role == '0' || $role == '2') { ?>
		<li class="parent <?php echo ($this->uri->segment(1) == 'parameter') ? 'active' : '' ?>">
			<a href="#">
				<span data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Pembobotan Sub Kriteria
			</a>
			<ul class="children collapse" id="sub-item-2">
				<li>
					<a class="" href="<?php echo site_url('parameter/bobotRev/1') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kompetensi Soft
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('parameter/bobotRev/2') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kompetensi Bisnis
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('parameter/bobotRev/3') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kompetensi Manajerial
					</a>
				</li>	
				<li>
					<a class="" href="<?php echo site_url('parameter/bobotRev/4') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Kompetensi Produksi
					</a>
				</li>					
			</ul>
		</li>
		<?php } ?>

		<li class="parent <?php echo ($this->uri->segment(1) == 'hasil') ? 'active' : '' ?>">
			<a href="#">
				<span data-toggle="collapse" href="#sub-item-3"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Proses Perankingan
			</a>
			<ul class="children collapse" id="sub-item-3">
				<?php if ($role == '0') { ?>
				<li>
					<a class="" href="<?php echo site_url('hasil/matriksKeputusan') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Matriks Keputusan
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/matriksKeputusanTernormalisasi') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Matriks Ternormalisasi
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/matriksTernormalisasiTerbobot') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Ternormalisasi Terbobot
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/utilityMeasure') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Utility Measure
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/indeksVikor') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Indeks VIKOR (Q)
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/kompetensiRank') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Hasil Rank Kompetensi
					</a>
				</li>	
				<li>
					<a class="" href="<?php echo site_url('hasil/cekPerankingan') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Cek Rank Kelompok
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/rankingKelompok') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Agregasi Keputusan
					</a>
				</li>	
				<?php }else{ ?>
				<li>
					<a class="" href="<?php echo site_url('hasil/individu') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Hasil Rank Individu
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('hasil/rankingKelompok') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Hasil Rank Kelompok
					</a>
				</li>
				<?php } ?>
												
			</ul>
		</li>

		<?php if ($role == '0') { ?>
		<li class="parent <?php echo ($this->uri->segment(1) == 'agregasi') ? 'active' : '' ?>">
			<a href="#">
				<span data-toggle="collapse" href="#agregasi"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Proses Agregasi
			</a>
			<ul class="children collapse" id="agregasi">
				<li>
					<a class="" href="<?php echo site_url('agregasi/rankingDm') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Perankingan DM
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('agregasi/borda') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Perhitungan Borda
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('agregasi/bordaBobotDm') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Borda dengan Bobot DM
					</a>
				</li>
				<li>
					<a class="" href="<?php echo site_url('agregasi/rankingKelompok') ?>">
						<svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Ranking Kelompok
					</a>
				</li>					
			</ul>
		</li>
		<?php } ?>
		
	</ul>

</div><!--/.sidebar-->