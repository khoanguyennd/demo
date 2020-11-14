import os
import traceback
from flask import Flask, jsonify, Response
from selenium import webdriver
from selenium.webdriver.chrome.webdriver import WebDriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import warnings
warnings.filterwarnings('ignore')
import time

from pyvirtualdisplay import Display


app = Flask(__name__)

# Add the webdrivers to the path
os.environ['PATH'] += ':'+os.path.dirname(os.path.realpath(__file__))+"/webdrivers"


@app.route('/')
def hello():
    return 'Hello!!'

@app.route('/test/', methods=['GET'])
def go_headless():
    usr = "ysjlabs"
    pwd = "yakeun87!@"
    path = "/Users/LG/PycharmProjects/webScraping/chromedriver86"
    #driver: WebDriver = webdriver.PhantomJS()
    driver: WebDriver = webdriver.Chrome()
    # driver: WebDriver = webdriver.Chrome(path)
    driver.get("https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr")

    elem = driver.find_element_by_id("user-id")
    elem.send_keys(usr)
    elem = driver.find_element_by_id("passWord")
    elem.send_keys(pwd)
    elem.send_keys(Keys.RETURN)
    driver.implicitly_wait(5)

    driver.get("https://soffice.11st.co.kr/product/UnitProductRegAction.tmall?method=regForm&urlType=SO")
    driver.implicitly_wait(5)

    driver.find_element_by_id('tool-1011').click()
    driver.find_element_by_css_selector('button.dialog_close').send_keys(Keys.RETURN)

    elem = driver.find_element_by_id("category0")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        print("Value is: %s" % option.get_attribute("value"))
        if option.get_attribute('value') == '154157':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("category1")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '117025:N:03:N:01::Y:::N:N':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("category2")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '1017871:N:03:N:01::N:::N:N':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("category3")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '1017872:N:03:N:09::N:01::Y:N':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("category4")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '1129331:Y:03:N:09::N:01::Y:N':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("prdNm").send_keys('bbbbb')
    driver.find_element_by_css_selector('button.btn_type_01').send_keys(Keys.RETURN)
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("selPrdTypCd")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '10':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("prdImage01").send_keys(os.getcwd() + "/Screenshot_10.png")
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("selPrc").send_keys('1000')
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("prdSelQty").send_keys('100')

    driver.find_element_by_id("chkPrdDesc_Html").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.switch_to.frame(driver.find_element_by_id("_ifrmEditorHtmlDetail"))
    ## Insert text via xpath ##
    driver.find_element_by_id("espresso_WYSIWYGEditor_HtmlEditor").clear()
    driver.find_element_by_id("espresso_WYSIWYGEditor_HtmlEditor").send_keys('bbbbb')
    ## Switch back to the "default content" (that is, out of the iframes) ##
    driver.switch_to.default_content()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("prdInfoTypeOpt")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '891011':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo01").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo02").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo03").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo04").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo05").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo06").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo07").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo08").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo09").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo010").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo269115").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("chkhgrnkAttrNo269117").click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("dlvCnAreaCd")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        if option.get_attribute('value') == '03':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    elem = driver.find_element_by_id("dlvWyCd")
    all_options = elem.find_elements_by_tag_name("option")
    for option in all_options:
        print("Value is: %s" % option.get_attribute("value"))
        if option.get_attribute('value') == '04':
            option.click()
    WebDriverWait(driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

    driver.find_element_by_id("ASDetail").send_keys('bbbbb')
    driver.find_element_by_id("rtngExchDetail").send_keys('bbbbb')

    driver.find_element_by_css_selector('a.btnC').click()
    WebDriverWait(driver, 30).until(lambda driver: driver.execute_script("return jQuery.active == 0"))
    driver.implicitly_wait(30)

    driver.switch_to.frame(driver.find_element_by_id("_ifrmRegProcess"))

    print('aaaaa')
    time.sleep(30)
    page_source = driver.page_source.encode("utf-8")
    driver.quit()

    return page_source

@app.route('/gmarket/', methods=['GET'])
def gmartket():
    # Give the location of the file
    #loc = ("path of file")
    return 'have a nice date'

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=8080, debug=True)