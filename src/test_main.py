import pytest
from unittest.mock import patch, MagicMock
from hal import hal_led, hal_lcd, hal_keypad, hal_buzzer, hal_rfid_reader
import queue
import time
import database as db
import main
from main import key_pressed, delete_key_pressed, display_main_menu

@pytest.fixture
def shared_keypad_queue():
    return queue.Queue()

@pytest.fixture
def lcd():
    return hal_lcd.lcd()

@pytest.fixture
def keypad_thread():
    return MagicMock()

@pytest.fixture
def keypad():
    return hal_keypad

@pytest.fixture
def buzzer():
    return hal_buzzer

@pytest.fixture
def rfid_reader():
    reader = hal_rfid_reader.init()
    return reader

@pytest.fixture
def cam():
    return MagicMock()

@pytest.fixture
def db():
    return MagicMock()

@pytest.fixture
def LED():
    return hal_led


def test_camera_scanning(cam, db, shared_keypad_queue):
    hal_led.init()
    hal_buzzer.init()
    cam.scan_barcode.return_value = "1234567890"
    db.fetch_product_name.return_value = "Product 1"
    db.fetch_product_price.return_value = 10.0
    shared_keypad_queue.put(1)
   
    assert main.camera_scanning() == 1
  

def test_verify_pin():
    hal_led.init()
    hal_buzzer.init()
    assert main.verify_pin("1234") == 1
    assert main.verify_pin("0000") == 0

def test_pay_with_paywave(rfid_reader):
    main.pay_with_paywave()
    assert str(rfid_reader.read_id_no_block) != "None"




