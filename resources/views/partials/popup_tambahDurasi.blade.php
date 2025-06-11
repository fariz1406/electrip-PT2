<!DOCTYPE html>
<html>

  <style>
    .popup {
      display: none;
      position: fixed;
      color: white;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #262626;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px black;
      z-index: 99;
    }

    .isi-popup {
      margin-bottom: 20px;
      text-align: center;
    }

    /* button */
    .tombol-popup-wrapper {
      margin-top: 18px;
      display: flex;
      justify-content: end;
      align-items: end;
    }

    .tombol-popup {
      border: none;
      padding: 12px 24px;
      border-radius: 24px;
      font-size: 12px;
      font-size: 0.8rem;
      letter-spacing: 2px;
      cursor: pointer;
    }

    .batal-popup {
      background: transparent;
      color: #ffcc00;
      border: 1px solid #ffcc00;
      transition: all 0.3s ease;
    }

    .batal-popup:hover {
      transform: scale(1.125);
      color: red;
      border-color: red;
      transition: all 0.3s ease;
    }

    .oke-popup {
      background: #ffcc00;
      color: rgba(255, 255, 255, 0.95);
      filter: drop-shadow(0);
      font-weight: bold;
      transition: all 0.3s ease;
      margin-left: 10px;
    }

    .oke-popup:hover {
      transform: scale(1.125);
      border-color: rgba(255, 255, 255, 0.9);
      filter: drop-shadow(0 10px 5px rgba(0, 0, 0, 0.125));
      transition: all 0.3s ease;
      background-color: green;
    }
    /* batas button */
  </style>

  <!-- <button onclick="showPopup()">Tampilkan Pop-up</button>

    <div id="popup-box" class="popup">
      <div class="isi-popup">
        <h2>Sebelum Melakukan Penyewaan <br>
           <span style="color: #ffcc00;">Verifikasi</span> Terlebih Dahulu</h2>
      </div>
        <div class="tombol-popup-wrapper">
        <button class="tombol-popup batal-popup" onclick="hidePopup()">Batal</button>
        <a href="">
          <button class="tombol-popup oke-popup">Oke</button></a>
        </div>
    </div> -->
  
</html>
