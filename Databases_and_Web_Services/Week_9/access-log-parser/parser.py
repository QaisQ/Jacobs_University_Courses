import re
import csv


#reads all ip addresses and puts them in an array
def ip_reader(filename):
    with open(filename, "r") as access_log:

        #filters log into site that include target website/link (~sgurubacharia)
        match_list = []
        for line in access_log:
            for match in re.finditer('~sgurubacha', line, re.S):
                match_list.append(line)

        # turn the list into a string
        match_list = ''.join(match_list)

        #match and find all ip addresses.
        regexp = r'\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}'
        ips_list = re.findall(regexp, match_list)




    access_log.close() #close file
    return(ips_list)


def time_reader(filename):
    access_logs = open(filename, "r")
    match_list = []
    
    for line in access_logs:
        for match in re.finditer('~sgurubacha', line, re.S):
            match_list.append(line)

    match_list = "".join(match_list)


    regexp = r"(?<=\[)(.*?)(?=\])"
    
    date_list = re.findall(regexp, match_list)

    access_logs.close()
    print(date_list)
    print(len(date_list))
    return(date_list)


def request_reader(filename):
    with open(filename, "r") as access_logs:
        match_list = []
        for line in access_logs:
            for match in re.finditer('~sgurubacha', line, re.S):
                match_list.append(line)

        match_list = "".join(match_list)

        regexp = r"(?<=POST )|(?<=GET ).*?(?= HTTP)"
        request_list = re.findall(regexp, match_list)     

        access_logs.close()
        return request_list

        
        
def browser_reader(filename):
    with open(filename, "r") as access_logs:
        match_list = []
        for line in access_logs:
            for match in re.finditer('~sgurubacha', line, re.S):
                match_list.append(line)
        
        match_list = "".join(match_list)

        regexp = r"(?<=\" \").*(?=\")"
        
        all_browsers = re.findall(regexp, match_list)


        access_logs.close()
        return all_browsers
    
            
def write_csv(ip_address_list, access_time_list, http_requests ,browser):
    with open("AccessLog_Output.csv", "w", newline = "\n") as output:
        writer = csv.writer(output)
        
        header = ["IP", "Access Time", "HTTP Requests", "Browser"]
        writer.writerow(header)

        for index in range(0, len(browser)):
            writer.writerow((ip_address_list[index], access_time_list[index], http_requests[index], browser[index]))
    output.close()
    print("Write Successful...")
    
if __name__ == "__main__":  
    write_csv(ip_reader("access_log"), time_reader("access_log"), request_reader("access_log") ,browser_reader("access_log"))



#Implemented Counter function before I realised it already existed as "from collection import Counter"

 # count_dict = {}
   # for log in request_list:
    #     if log not in count_dict:
    #         count_dict[log] = 1
    #     else:
    #         count_dict[log] += 1