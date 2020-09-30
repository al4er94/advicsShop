<title> <?php echo $title;?></title>
<?php echo $header; ?>

 <div class="container">
  <ul class = "breadcrumb" >
	<?php foreach($breadcrumbs as $breadcrumb){ ?>
		<li> <a href = "<?php echo $breadcrumb['href'];?>"> <?php echo $breadcrumb['text'];?></a></li> 
	<?php } ?>
 </ul>
    <div id="content" class="advics_search"><?php echo $content_top; ?>
        <h1><?php echo $title; ?></h1>
        <div id="searchForm">
            <form name ="searchAdvics">
                <span class="custom-dropdown big">
                <select name="maker" class="active" id ="maker" onchange="advicsSearch.getModels(document.searchAdvics.maker.value);">
                    <option value="" selected="">Выберите производителя</option>
                    <option value="1"> </option>
                    <option value="2">ACURA</option>
                    <option value="3">BYD</option>
                    <option value="4">CHERY</option>
                    <option value="5">CHEVROLET (JAPAN)</option>
                    <option value="6">CITROEN</option>
                    <!--<option value="7">DAIHATSU</option>
                    <option value="8">DODGE</option>
                    <option value="9">FORD</option>
                    <option value="10">FUSO</option>
                    <option value="11">GEELY</option>
                    <option value="12">HINO</option> -->
                    <option value="13">HONDA</option>
                    <option value="14">INFINITI</option>
                    <!--<option value="15">ISUZU</option>
                    <option value="16">JEEP</option>
                    <option value="17">KIA</option>
                    <option value="18">LADA</option> -->
                    <option value="19">LEXUS</option>
                   <!-- <option value="20">LIFAN</option> -->
                    <option value="21">MAZDA</option>
                    <option value="22">MITSUBISHI</option>
                    <option value="23">NISSAN</option>
                    <!--<option value="24">OPEL</option>
                    <option value="25">PEUGEOT</option>
                    <option value="26">RENAULT</option>
                    <option value="27">SCION</option>-->
                    <option value="28">SUBARU</option>
                    <option value="29">SUZUKI</option>
                    <option value="30">TOYOTA</option>
                    <!--<option value="31">VOLVO</option>-->
                </select>
                </span>
                <span class="custom-dropdown big">  
                    <select name="model" class="" id ="model" onchange="advicsSearch.getChasis(document.searchAdvics.model.value);"><option value="">Выберите модель</option></select>
                </span>
                <span class="custom-dropdown big">
                    <select name="chassis" class="custom-dropdown big" id ="chassis" onchange="advicsSearch.unblockSearchButton();">
                    <option value="">Выберите кузов</option>
                    </select>
                </span>
            </form>
			<div class = "searchButton">
            <button disabled id="searchButton" onclick = "advicsSearch.searchPrice()"> Подобрать запчасть </button></div>
        </div>
        <div class="table-wrap">
			<div class = "table_content">
				Всего 3 шага для быстрого подбора фирменных запчатей! 
			</div>
            <table class="table table-3" style="display:none;">
              <thead>
                <tr>
                  <th>Марка</th>
                  <th>Модель</th>
                  <th>Кузов</th>
                  <th>Объём</th>
                  <th>Период выпуска</th>
                  <th>Передние колодки</th>
                  <th>Задние колодки</th>
                  <th>Передний диск</th>
                  <th>Задний диск</th>
                </tr>
              </thead>
              <tbody id = "priceTable">

              </tbody>
            </table>
        </div>
    </div>
</div>


<?php echo $footer; ?>
