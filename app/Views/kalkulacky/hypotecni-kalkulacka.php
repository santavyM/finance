<?=$this->extend("layout/master")?>

<?=$this->section("content")?>

<div class="hypotecni">
    <div class="loan-calculator">
      <div class="top">
        <h1 class="title">Loan Calculator</h1>

        <form action="#">
          <div class="group">
            <div class="title-calculator">Výška úvěru
            </div>
            <div class="group1">
              <input type="text" value="30000" class="loan-amount"></input>
              <span class="after">Kč</span>
            </div>
          </div>

          <div class="group">
            <div class="title-calculator">úroková míra
            </div>
            <div class="group1">
              <input type="text" value="8.5" class="interest-rate" />
              <span class="after">%</span>
            </div>
          </div>

          <div class="group">
            <div class="title-calculator">Doba splácení 
            </div>
            <div class="group1">
              <input type="text" value="240" class="loan-tenure" />
              <span class="after">měsíců</span>
            </div>
          </div>
        </form>
      </div>

      <div class="result">
        <div class="left">
          <div class="loan-emi">
            <h3>Loan EMI</h3>
            <div class="value">123</div>
          </div>

          <div class="total-interest">
            <h3>Total Interest Payable</h3>
            <div class="value">1234</div>
          </div>

          <div class="total-amount">
            <h3>celková částka</h3>
            <div class="value">12345</div>
          </div>

          <button class="calculate-btn btn-color2">Calculate</button>
        </div>

        <div class="right">
          <canvas id="myChart" width="400" height="400"></canvas>
        </div>
      </div>
    </div>
</div>

<script>
  
</script>
<?=$this->endSection()?>
