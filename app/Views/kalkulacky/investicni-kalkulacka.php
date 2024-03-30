<?=$this->extend("layout/master")?>

<?=$this->section("content")?>
    <div class="mortgage-calculator">
          <div class="top">
             <h1 class="title">Investiční Kalkulačka</h1>
            <form class="calculator calculator-compound-interest calculator-form" id="calculator-compound-interest">
              <div class="flex">
                <div class="group">
                    <label for="start-investment"> <span>Počáteční jednorázová investice</span> 
                    <input id="start-investment" type="number" min="0" name="start-investment" value="100000" data-default="100000" > </label> 
                </div>
                <div class="group">
                    <label for="monthly-investment"> <span>Pravidelná měsíční investice</span> 
                    <input id="monthly-investment" type="number" min="0" name="monthly-investment" value="1000" data-default="1000" > </label> 
                </div>
                <div class="group">
                    <label for="annual-interest-rate"> <span>Předpokládaná roční úroková sazba (%)</span> 
                    <input id="annual-interest-rate" type="number" min="0.01" step="0.01" name="annual-interest-rate" value="<?= get_calculators()->invest ?>" data-default="<?= get_calculators()->invest ?>" > </label>
                </div>
                <div class="group">
                    <label for="investment-years"> <span>Na kolik let investování</span> </label>
                    <input id="investment-years" type="number" min="1" name="investment-years" value="30" data-default="30">
                </div>
              </div>
              <div class="input-group" style="margin-top:10px">
                 <button class="calculate-btn btn-color1 calculate">Spočítej</button>
              </div>
            </form>
        </div>
        <div id="calculator-compound-interest-result" class="calculator calculator-results calculator-compound-interest-results" style="text-align:center">
            <h3><b>Výsledek</b></h3>
            <div class="calculator-error-info" style="display: none;"><b> Prosím doplň informace.</b></div>
            <div class="calculator-result-row"> <span class="calculator-result-row-title">Investovaná částka:</span> <b><span class="calculator-result-row-value" data-result="investedValue" data-suffix="Kč">484 000 Kč</span></b></div>
            <div class="calculator-result-row"> <span class="calculator-result-row-title">Obdržený úrok:</span> <b><span class="calculator-result-row-value" data-result="receivedInterest" data-suffix="Kč">1 877 651 Kč</span></b></div>
            <div class="calculator-result-row"> <span class="calculator-result-row-title">Výsledná částka:</span> <b><span class="calculator-result-row-value" data-result="finalValue" data-suffix="Kč">2 361 651 Kč</span></b></div> 
            <div class="results">
            <canvas id="cicChart" ></canvas>
        </div>
    </div>
</div>
    <script type="text/javascript" src="<?= base_url('assets/bootstrap/js/kalkulacka1.js'); ?>"></script>
<?=$this->endSection()?>
