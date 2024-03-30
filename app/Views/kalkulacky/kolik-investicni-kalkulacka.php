<?=$this->extend("layout/master")?>

<?=$this->section("content")?>
<div class="mortgage-calculator">
    <div class="top">
        <h1 class="title">Kolik mám měsíčně investovat?</h1>
      <form class="calculator calculator-how-invest calculator-form" id="calculator-rent" onsubmit="event.preventDefault();">
        <div class="flex">
          <div class="group">
              <label for="start-investment"> <span>Počáteční jednorázová investice</span> 
              <input id="start-investment" type="number" min="0" name="start-investment" value="10000" data-default="10000" > </label> 
              <input id="slider-start-investment" type="range" min="10000" max="100000" name="start-investment" value="10000" data-default="10000" step="1000"> </label> 
          </div>
          <div class="group">
              <label for="goal-investment"> <span>Cílová částka vašeho investování</span> 
              <input id="goal-investment" type="number" min="0" name="goal-investment" value="1000000" data-default="1000000" > </label> 
              <input id="slider-goal-investment" type="range" min="100000" max="1000000" name="goal-investment" value="1000000" data-default="1000000" step="10000"> </label> 
          </div>
          <div class="group">
              <label for="annual-interest-rate"> <span>Výnos po dobu investice (%)</span> 
              <input id="annual-interest-rate" type="number" min="0.01" step="0.01" name="annual-interest-rate" value="<?= get_calculators()->invest ?>" data-default="<?= get_calculators()->invest ?>" > </label>
          </div>
          <div class="group">
              <label for="investment-years"> <span>Po jakou dobu budete investovat?</span></span> </label>
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
      <div class="calculator-result-row"> <span class="calculator-result-row-title">Potřebná měsíční investice:</span> <b><span class="calculator-result-row-value" data-result="finalValue" data-suffix="Kč">2 361 651 Kč</span></b></div> 
      <div class="calculator-result-row"> <span class="calculator-result-row-title">Vaše vklady celkem:</span> <b><span class="calculator-result-row-value" data-result="investedValue" data-suffix="Kč">484 000 Kč</span></b></div>
      <div class="calculator-result-row"> <span class="calculator-result-row-title">Zhodnocení:</span> <b><span class="calculator-result-row-value" data-result="receivedInterest" data-suffix="Kč">1 877 651 Kč</span></b></div>
      <div class="pie-results" >
      <canvas id="ficChart"></canvas>
      </div>
  </div>
</div>


<script>

</script>
<?=$this->endSection()?>
