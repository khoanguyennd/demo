# import argparse
# import sys
# import requests
# import json

# from random import randint
# from time import sleep
 
# from selenium import webdriver


import os

from selenium import webdriver
from selenium.webdriver.chrome.webdriver import WebDriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

import time
import warnings
warnings.filterwarnings('ignore')
 
#FB_URL = "https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr"
 
 
# def random_sleep(min_s, max_s):
#     sleep(randint(min_s, max_s))
 
 
class S11tLogin:
    # def __init__(self, username, password):
    #     self.username = username
    #     self.password = password
    #     self.driver = webdriver.Chrome()
 
    # def login(self):
    #     self.driver.get(FB_URL)
    #     username_ele = self.driver.find_element_by_css_selector('#user-id')
    #     username_ele.send_keys(self.username)
    #     # random_sleep(1, 5)
    #     password_ele = self.driver.find_element_by_css_selector('#passWord')
    #     password_ele.send_keys(self.password)
    #     random_sleep(1, 5)
    #     login_ele = self.driver.find_element_by_css_selector('button[type="submit"]')
    #     # random_sleep(1, 5)
    #     login_ele.click()

    def createPro(self):
        usr = "ysjlabs"
        pwd = "yakeun87!@"
        # path = "/Users/LG/PycharmProjects/webScraping/chromedriver86"
        self.driver: WebDriver = webdriver.Chrome() 
        #self.driver: WebDriver = webdriver.PhantomJS()
        self.driver.get("https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr")

        elem = self.driver.find_element_by_id("user-id")
        elem.send_keys(usr)
        elem = self.driver.find_element_by_id("passWord")
        elem.send_keys(pwd)
        elem.send_keys(Keys.RETURN)
        self.driver.implicitly_wait(5)

        self.driver.get("https://soffice.11st.co.kr/product/UnitProductRegAction.tmall?method=regForm&urlType=SO")
        self.driver.implicitly_wait(5)

        self.driver.find_element_by_id('tool-1011').click()
        self.driver.find_element_by_css_selector('button.dialog_close').send_keys(Keys.RETURN)

        elem = self.driver.find_element_by_id("category0")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            print("Value is: %s" % option.get_attribute("value"))
            if option.get_attribute('value') == '154157':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("category1")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '117025:N:03:N:01::Y:::N:N':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("category2")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '1017871:N:03:N:01::N:::N:N':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("category3")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '1017872:N:03:N:09::N:01::Y:N':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("category4")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '1129331:Y:03:N:09::N:01::Y:N':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("prdNm").send_keys('bbbbb')
        self.driver.find_element_by_css_selector('button.btn_type_01').send_keys(Keys.RETURN)
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("selPrdTypCd")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '10':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("prdImage01").send_keys(os.getcwd()+"/Screenshot_10.png")
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("selPrc").send_keys('1000')
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("prdSelQty").send_keys('100')


        self.driver.find_element_by_id("chkPrdDesc_Html").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))


        self.driver.switch_to.frame(self.driver.find_element_by_id("_ifrmEditorHtmlDetail"))
        ## Insert text via xpath ##
        self.driver.find_element_by_id("espresso_WYSIWYGEditor_HtmlEditor").clear()
        self.driver.find_element_by_id("espresso_WYSIWYGEditor_HtmlEditor").send_keys('bbbbb')
        ## Switch back to the "default content" (that is, out of the iframes) ##
        self.driver.switch_to.default_content()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("prdInfoTypeOpt")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '891011':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))



        self.driver.find_element_by_id("chkhgrnkAttrNo01").click()
        WebDriverWait(self.driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo02").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo03").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo04").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo05").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo06").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo07").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo08").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo09").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo010").click()
        WebDriverWait(self.driver, 5).until(lambda driver: driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo269115").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("chkhgrnkAttrNo269117").click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("dlvCnAreaCd")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '03':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        elem = self.driver.find_element_by_id("dlvWyCd")
        all_options = elem.find_elements_by_tag_name("option")
        for option in all_options:
            if option.get_attribute('value') == '04':
                option.click()
        WebDriverWait(self.driver, 5).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))

        self.driver.find_element_by_id("ASDetail").send_keys('bbbbb')
        self.driver.find_element_by_id("rtngExchDetail").send_keys('bbbbb')


        self.driver.find_element_by_css_selector('a.btnC').send_keys(Keys.RETURN)
        WebDriverWait(self.driver, 50).until(lambda driver: self.driver.execute_script("return jQuery.active == 0"))
        self.driver.implicitly_wait(50)

 
    # def verify_login(self):
    #     try:
    #         self.driver.find_element_by_css_selector('#user-id')
    #         return False
    #     except:
    #         return True
 
 
# if __name__ == '__main__':
#     parser = argparse.ArgumentParser(description='Auto FB login')
#     parser.add_argument('--username', default=None, required=True, help='FB username')
#     parser.add_argument('--password', default=None, required=True, help='FB password')
 
#     try:
#         options = parser.parse_args()
#     except:
#         parser.print_help()
#         sys.exit(0)

s11l = S11tLogin()
s11l.createPro()
    #s11l.login()
    # s11l.createPro()
    # if s11l.verify_login():
    #     print('Login is successful!')
       
    #     resp = requests.get('https://reactnative.dev/movies.json', headers={"Content-Type": "application/json"})
    #     print(resp)
    #     todos = json.loads(resp.text)
    #     print(todos['description'])
    #     for obj in todos['movies']:
    #        print(obj['title'])
    # else:
    #     print('Login is failed!')
 
    #s11l.driver.close()