import pytest
from unittest.mock import patch, MagicMock
from hal import hal_lcd as LCD
from hal import hal_keypad as keypad
from hal import hal_buzzer as buzzer
from hal import hal_rfid_reader as rfid_reader
import main

@pytest.fixture
def lcd_mock():
    return MagicMock(spec=LCD.lcd)

@pytest.fixture
def keypad_mock():
    return MagicMock(spec=keypad)

@pytest.fixture
def buzzer_mock():
    return MagicMock(spec=buzzer)

@pytest.fixture
def rfid_reader_mock():
    return MagicMock(spec=rfid_reader)

def test_display_main_menu(lcd_mock):
    main.LCD.lcd = lcd_mock
    main.display_main_menu()
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("1. Start self-checkout", 1)
    lcd_mock.lcd_display_string.assert_called_with("2. Enter Idle Mode", 2)

def test_menu_selection_option_1(lcd_mock):
    main.LCD.lcd = lcd_mock
    main.menu_selection(1)
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Hold your items", 1)
    lcd_mock.lcd_display_string.assert_called_with("at reader one by one", 2)
    assert main.camera_scanning() == None

def test_menu_selection_option_2(lcd_mock, keypad_mock):
    main.LCD.lcd = lcd_mock
    main.keypad.get_key = keypad_mock.get_key
    keypad_mock.get_key.return_value = 1
    main.menu_selection(2)
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Entering Idle Mode", 1)
    lcd_mock.lcd_display_string.assert_called_with("", 2)
    keypad_mock.get_key.assert_called_once()
    assert main.home_screen() == None

def test_display_payment_screen(lcd_mock, keypad_mock):
    main.LCD.lcd = lcd_mock
    main.keypad.get_key = keypad_mock.get_key
    keypad_mock.get_key.return_value = 1
    main.display_payment_screen(10)
    lcd_mock.lcd_display_string.assert_called_with("Total Price: $10", 1)
    lcd_mock.lcd_display_string.assert_called_with("Press 1 to pay", 2)
    keypad_mock.get_key.assert_called_once()
    assert main.display_payment_method_menu() == None

def test_display_payment_method_menu_option_1(lcd_mock, keypad_mock):
    main.LCD.lcd = lcd_mock
    main.keypad.get_key = keypad_mock.get_key
    keypad_mock.get_key.return_value = 1
    main.display_payment_method_menu()
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Payment Method?", 1)
    lcd_mock.lcd_display_string.assert_called_with("1.ATM,2.PayWave", 2)
    keypad_mock.get_key.assert_called_once()
    assert main.pay_with_atm() == None

def test_display_payment_method_menu_option_2(lcd_mock, keypad_mock):
    main.LCD.lcd = lcd_mock
    main.keypad.get_key = keypad_mock.get_key
    keypad_mock.get_key.return_value = 2
    main.display_payment_method_menu()
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Payment Method?", 1)
    lcd_mock.lcd_display_string.assert_called_with("1.ATM,2.PayWave", 2)
    keypad_mock.get_key.assert_called_once()
    assert main.pay_with_paywave() == None

def test_verify_pin(lcd_mock):
    main.LCD.lcd = lcd_mock
    main.verify_pin("1234")
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Verifying", 1)
    assert main.verify_pin("5678") == None

def test_pay_with_paywave(lcd_mock, rfid_reader_mock):
    main.LCD.lcd = lcd_mock
    main.rfid_reader.init = rfid_reader_mock.init
    rfid_reader_mock.read_id_no_block.return_value = "123456"
    main.pay_with_paywave()
    lcd_mock.lcd_clear.assert_called_once()
    lcd_mock.lcd_display_string.assert_called_with("Tap your card", 1)
    rfid_reader_mock.read_id_no_block.assert_called_once()