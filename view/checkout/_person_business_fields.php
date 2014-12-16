<li>
  <label for="ebanx_company_name" class="required">Nome da empresa</label>
  <div class="input-box">
    <input type="text" title="Nome da empresa" class="input-text required-entry" id="ebanx_company_name" name="ebanx[company_name]"
    value="<?php echo isset($_POST['ebanx']['company_name']) ? $_POST['ebanx']['company_name'] : $companyName ?>">
  </div>
</li>

<li>
  <label for="ebanx_document_business" class="required">CNPJ</label>
  <div class="input-box">
    <input type="text" title="CNPJ" class="input-text required-entry" id="ebanx_document_business" name="ebanx[document_business]"
    value="<?php echo isset($_POST['ebanx']['document_business']) ? $_POST['ebanx']['document_business'] : '' ?>">
  </div>
</li>


<li>
  <label for="ebanx_responsible_name" class="required">Nome do responsável</label>
  <div class="input-box">
    <input type="text" title="Nome do responsável" class="input-text required-entry" id="ebanx_responsible_name" name="ebanx[responsible_name]"
    value="<?php echo isset($_POST['ebanx']['responsible_name']) ? $_POST['ebanx']['responsible_name'] : $responsible ?>">
  </div>
</li>

<li>
  <label for="ebanx_responsible_document" class="required">CPF do responsável</label>
  <div class="input-box">
    <input type="text" title="CPF" class="input-text required-entry" id="ebanx_responsible_document" name="ebanx[responsible_document]"
    value="<?php echo isset($_POST['ebanx']['responsible_document']) ? $_POST['ebanx']['responsible_document'] : $ebanxDocument ?>">
  </div>
</li>

<li>
  <label for="ebanx_responsible_birth_day" class="required">Data de nascimento do responsável</label>
  <div class="input-box ebanx-birth">
    <div class="v-fix">
      <select id="ebanx_responsible_birth_day" name="ebanx[responsible_birth_day]" class="day required-entry" autocomplete="off">
        <option value="" selected="selected">Dia</option>
        <?php for ($i = 1; $i <= 31; $i++): ?>
          <option value="<?php echo $i ?>" <?php if (isset($birthDate['day']) && $birthDate['day'] == $i) echo 'selected'?>>
            <?php echo $i ?>
          </option>
        <?php endfor ?>
      </select>
    </div>

    <div class="v-fix">
      <select id="ebanx_responsible_birth_month" name="ebanx[responsible_birth_month]" class="month required-entry" autocomplete="off">
        <option value="" selected="selected">Mês</option>
        <?php for ($i = 1; $i <= 12; $i++): ?>
          <option value="<?php echo $i ?>" <?php if (isset($birthDate['month']) && $birthDate['month'] == $i) echo 'selected'?>>
            <?php echo str_pad($i, 2, '0', STR_PAD_LEFT) ?>
          </option>
        <?php endfor ?>
      </select>
    </div>

    <div class="v-fix">
      <select id="ebanx_responsible_birth_year" name="ebanx[responsible_birth_year]" class="year required-entry" autocomplete="off">
        <option value="" selected="selected">Ano</option>
        <?php for ($i = date('Y') - 16; $i > 1920; $i--): ?>
          <option value="<?php echo $i ?>" <?php if (isset($birthDate['year']) && $birthDate['year'] == $i) echo 'selected'?>>
            <?php echo $i ?>
          </option>
        <?php endfor ?>
      </select>
    </div>
  </div>
</li>