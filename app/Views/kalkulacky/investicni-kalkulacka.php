<?=$this->extend("layout/master")?>

<?=$this->section("content")?>
        <div class="mortgage-calculator">
          <div class="top">
             <h1 class="title">Investiční Kalkulačka</h1>
            <form class="compound-form">
              <div class="flex">
                <div class="group">
                    <label for="initialamount">roč. částka</label>
                    <input type="number" value="1000" id="initialamount" />
                </div>
                <div class="group">
                    <label for="years">Let investování</label>
                    <input type="number" value="10" id="years" />
                </div>
                <div class="group">
                    <label for="rates">Zhodnocení(%)</label>
                    <input type="number" value="10" id="rates" />
                </div>
                <div class="group">
                    <label for="rates">roční investice</label>
                    <select id="compound">
                        <option value="1">jednou</option>
                        <option value="4">čtvrtletně</option>
                        <option value="2">půlročně</option>
                        <option value="12">měsíčně</option>
                    </select>
                </div>
              </div>
              <div class="input-group">
                 <button class="calculate-btn btn-color1">Calculate</button>
              </div>
            </form>
        </div>
        <div class="results">
            <h3 id="message"></h3>
            <canvas id="data-set"></canvas>
        </div>
</div>
    <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/kalkulacka1.js'); ?>"></script>
<?=$this->endSection()?>
