import re
from collections import Counter

# Path to the SSH log file
LOG_FILE = '/var/log/auth.log'

# Threshold for number of attempts
ATTEMPT_THRESHOLD = 50

def extract_failed_attempts(log_file):
    """Extract IP addresses with failed login attempts from the log file."""
    ip_pattern = re.compile(r"Failed password.*from ([\d.]+)")
    attempts = []

    try:
        with open(log_file, "r") as file:
            for line in file:
                match = ip_pattern.search(line)
                if match:
                    attempts.append(match.group(1))
    except FileNotFoundError:
        print(f"Log file not found: {log_file}")
        return []
    except PermissionError:
        print(f"Permission denied to read the log file: {log_file}")
        return []

    return attempts

def find_frequent_attempts(attempts, threshold):
    """Find IPs with failed attempts greater than the threshold."""
    attempt_counts = Counter(attempts)
    return {ip: count for ip, count in attempt_counts.items() if count > threshold}

def main():
    # Extract failed attempts from the log file
    failed_attempts = extract_failed_attempts(LOG_FILE)

    # Find IP addresses exceeding the threshold
    frequent_attempts = find_frequent_attempts(failed_attempts, ATTEMPT_THRESHOLD)

    if frequent_attempts:
        print("IP addresses with more than 50 failed login attempts:")
        for ip, count in frequent_attempts.items():
            print(f"{ip}: {count} attempts")
    else:
        print("No IP addresses found with more than 50 failed login attempts.")

if __name__ == "__main__":
    main()
