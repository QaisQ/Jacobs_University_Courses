import csv
import re
from collections import Counter
from os import read

def error_reader(filename):
    with open(filename, "r") as error_log:
        # look for errors from our own website
        match_list = []
        for line in error_log:
            for match in re.finditer('~sgurubacha', line, re.S):
                match_text = line
                match_list.append(match_text)
                # print(match_text)

        # turn the list into a string
        match_list = ''.join(match_list) 

        regexp = r"(?<=\[)(.*?)(?=\])"

        data_list = re.findall(regexp, match_list)

        return(data_list)


def write_csv(data_list):
    with open('error_log.csv', 'w', newline="\n") as csvfile:
        writer = csv.writer(csvfile)

        header = ['Time', 'Type', 'PID', 'Client']

        writer.writerow(header)

        count =  0
        for item in data_list:
            if count == 0:
                time = item
                count += 1
            elif count == 1:
                type = item
                count +=1
            elif count == 2:
                pid = item
                count +=1
            elif count == 3:
                client = item
                writer.writerow((time, type, pid, client))
                count = 0
    print("Writing Error Log Successful...")


if __name__ == "__main__":

    write_csv(error_reader('error_log'))
