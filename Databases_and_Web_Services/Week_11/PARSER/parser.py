
def reader(filename):
    with open("access_log", "r") as access_log:
        log = access_log.read()



if __name__ = "__main__":
    reader("access_log")