import glob
import re
import gzip
import requests
from collections import Counter

# Path to log files (including rotated ones)
log_file_pattern = "/var/log/apache2/access.log*"

# Regex pattern to match IP addresses
ip_pattern = r"\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b"

# IPInfo API key
ACCESS_TOKEN = "4685e7c89b4d92"

def get_ip_location(ip):
    """Retrieve location details for a given IP address using a direct API request."""
    try:
        url = f"https://ipinfo.io/{ip}?token={ACCESS_TOKEN}"
        response = requests.get(url, timeout=5)
        if response.status_code == 200:
            data = response.json()
            city = data.get("city", "N/A")
            region = data.get("region", "N/A")
            country = data.get("country", "N/A")
            return f"{city}, {region}, {country}"
        else:
            return "Unknown Location"
    except requests.RequestException as e:
        print(f"Error retrieving location for {ip}: {e}")
        return "Unknown Location"

def find_frequent_attackers(log_files, threshold=50):
    """Find IPs with failed attempts greater than the threshold."""
    try:
        ip_counts = Counter()

        for log_file in log_files:
            open_func = gzip.open if log_file.endswith('.gz') else open
            try:
                with open_func(log_file, 'rt', encoding="utf-8", errors="ignore") as file:
                    for line in file:
                        match = re.search(ip_pattern, line)
                        if match:
                            ip_counts.update([match.group()])
            except Exception as e:
                print(f"An error occurred while reading {log_file}: {e}")

        return {ip: count for ip, count in ip_counts.items() if count > threshold}

    except FileNotFoundError:
        print("Error: One of the log files was not found.")
        return {}
    except Exception as e:
        print(f"An error occurred: {e}")
        return {}

if __name__ == "__main__":
    threshold = 50  # Set your threshold
    log_files = glob.glob(log_file_pattern)

    attackers = find_frequent_attackers(log_files, threshold)

    if attackers:
        print("IP addresses with more than 50 attacks:")
        print("IP Address        | Attempts | Location")
        print("--------------------------------------------------")
        for ip, count in attackers.items():
            location = get_ip_location(ip)
            print(f"{ip:<17} | {count:<8} | {location}")
    else:
        print("No attackers exceeded the threshold.")

