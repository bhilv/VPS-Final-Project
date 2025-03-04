import os
import glob
import gzip
import re
from collections import Counter

def extract_banned_ips(log_files):
    banned_ips = []
    ban_pattern = re.compile(r"Ban (\d+\.\d+\.\d+\.\d+)")
    
    for log_file in log_files:
        try:
            if log_file.endswith('.gz'):
                with gzip.open(log_file, 'rt', errors='ignore') as f:
                    for line in f:
                        match = ban_pattern.search(line)
                        if match:
                            banned_ips.append(match.group(1))
            else:
                with open(log_file, 'r', errors='ignore') as f:
                    for line in f:
                        match = ban_pattern.search(line)
                        if match:
                            banned_ips.append(match.group(1))
        except Exception as e:
            print(f"Error reading {log_file}: {e}")
    
    return banned_ips

def generate_report(banned_ips):
    ip_counter = Counter(banned_ips)
    print("Banned IP Report:")
    print("IP Address       | Ban Count")
    print("-----------------|----------")
    for ip, count in ip_counter.most_common():
        print(f"{ip:<15} | {count}")

def main():
    log_files = glob.glob('/var/log/fail2ban.log*')
    banned_ips = extract_banned_ips(log_files)
    if banned_ips:
        generate_report(banned_ips)
    else:
        print("No banned IPs found.")

if __name__ == "__main__":
    main()
