import pytest
from unittest.mock import MagicMock
import database as db

@pytest.fixture
def mock_db():
    return MagicMock()

def test_fetch_product_name():
    product_name = db.fetch_product_name("1000000001")
    assert product_name == "iPhone 15 Pro"

def test_fetch_product_price():
    product_price = db.fetch_product_price("1000000001")
    assert product_price == 499

def test_fetch_product_name_wrong():
    product_name = db.fetch_product_name("1000000000")
    assert product_name == "SKU not found"

def test_fetch_product_price_wrong():
    product_price = db.fetch_product_price("1000000000")
    assert product_price == 0
