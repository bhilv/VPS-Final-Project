#!/bin/bash

# Path to the fail2ban log file
log_file="Log.txt"

# Output directory
output_dir="playground"

# Temporary file for storing intermediate results
temp_file="temp_log.txt"

# Extract IP addresses and corresponding timestamps from the log file
awk '{print $1 " " $2 " " $3 " " $NF}' "$log_file" > "$temp_file"

# Generate unique output file name based on the current timestamp
output_file="$output_dir/attack_report_$(date +'%Y%m%d_%H%M%S').txt"

# Initialize the output file
echo "Weekly Top 5 Attackers:" > "$output_file"
echo "" >> "$output_file"

# Break down the attacks week by week
awk '{print $1 " " $2 " " $3 " " $4}' "$temp_file" | while read -r line; do
    date_str=$(echo "$line" | awk '{print $1 " " $2 " " $3}')
    ip=$(echo "$line" | awk '{print $4}')
    week=$(date -d "$date_str" +%Y%V)
    echo "$week $ip"
done | sort | uniq -c | sort -nr | awk '{print $2 " " $1}' | while read -r week ip count; do
    echo "$week $ip $count"
done | awk '{print $1}' | uniq | while read -r week; do
    echo "Week $week:" >> "$output_file"
    awk -v week="$week" '{if($1 == week) print $2 " - " $3 " attacks"}' | head -n 5 >> "$output_file"
    echo "" >> "$output_file"
done

# Clean up temporary file
rm "$temp_file"

echo "Attack report generated: $output_file"

