import requests
from bs4 import BeautifulSoup
import pandas as pd
from time import sleep
import random

def get_full_job_description(job_url, headers):
    """
    Scrape the full job description from the individual job page
    """
    try:
        # Add random delay before requesting job details
        sleep(random.uniform(1, 2))
        
        response = requests.get(job_url, headers=headers)
        response.raise_for_status()
        
        soup = BeautifulSoup(response.content, 'html.parser')
        
        # Find the job description section
        description_section = soup.find('div', class_='job-details__description')
        if description_section:
            # Get all paragraphs and lists from the description
            description_elements = description_section.find_all(['p', 'ul', 'ol'])
            full_description = '\n'.join([elem.get_text(strip=True) for elem in description_elements])
            return full_description
        return 'Description not found'
        
    except Exception as e:
        print(f"Error getting full job description from {job_url}: {str(e)}")
        return 'Error retrieving description'

def scrape_with_pagination(num_pages=5):
    all_jobs = []
    
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language': 'en-US,en;q=0.5',
        'Referer': 'https://useme.com/',
        'DNT': '1',
        'Connection': 'keep-alive',
        'Upgrade-Insecure-Requests': '1',
    }
    
    for page in range(1, num_pages + 1):
        try:
            url = f"https://useme.com/pl/jobs/?page={page}"
            print(f"Scraping page {page}...")
            
            # Add random delay between requests
            sleep(random.uniform(2, 4))
            
            response = requests.get(url, headers=headers)
            response.raise_for_status()
            
            soup = BeautifulSoup(response.content, 'html.parser')
            
            jobs_data = []
            job_listings = soup.find_all('article', class_='job')
            
            for job in job_listings:
                try:
                    # Extract username
                    username = job.find('strong').text.strip() if job.find('strong') else 'N/A'
                    
                    # Extract user avatar
                    avatar_img = job.find('img', class_='user-avatar__image')
                    avatar_url = avatar_img.get('src') or avatar_img.get('data-src', 'N/A') if avatar_img else 'N/A'
                    
                    # Extract number of offers
                    offers = job.find('div', class_='job__header-details--offers')
                    offers_count = offers.find('span', recursive=False).text.strip() if offers else 'N/A'
                    
                    # Extract time remaining
                    time_remaining = job.find('div', class_='job__header-details--date')
                    time_text = time_remaining.find_all('span')[-1].text.strip() if time_remaining else 'N/A'
                    
                    # Extract job title and URL
                    title_element = job.find('a', class_='job__title')
                    if title_element:
                        title = title_element.text.strip()
                        job_url = 'https://useme.com' + title_element.get('href', '')
                        # Get full job description from individual page
                        full_description = get_full_job_description(job_url, headers)
                    else:
                        title = 'N/A'
                        job_url = 'N/A'
                        full_description = 'N/A'
                    
                    # Extract preview description
                    preview_desc = job.find('p', class_='mb-0')
                    preview_desc_text = preview_desc.text.strip() if preview_desc else 'N/A'
                    
                    # Extract category
                    category_element = job.find('div', class_='job__category').find('a')
                    if category_element and category_element.find('p'):
                        category = category_element.find('p').text.strip()
                        category_url = 'https://useme.com' + category_element.get('href', '')
                    else:
                        category = 'N/A'
                        category_url = 'N/A'
                    
                    # Extract budget
                    budget_element = job.find('div', class_='job__budget')
                    budget = budget_element.find('span', class_='job__budget-value').text.strip() if budget_element else 'N/A'
                    
                    # Add to jobs_data
                    jobs_data.append({
                        'username': username,
                        'avatar_url': avatar_url,
                        'offers_count': offers_count,
                        'time_remaining': time_text,
                        'title': title,
                        'job_url': job_url,
                        'preview_description': preview_desc_text,
                        'full_description': full_description,
                        'category': category,
                        'category_url': category_url,
                        'budget': budget,
                        'page': page
                    })
                    
                    print(f"Successfully scraped job: {title}")
                    
                except Exception as e:
                    print(f"Error parsing individual job on page {page}: {str(e)}")
                    continue
            
            # Convert page data to DataFrame and append to all_jobs
            if jobs_data:
                df = pd.DataFrame(jobs_data)
                all_jobs.append(df)
                print(f"Successfully scraped {len(jobs_data)} jobs from page {page}")
            
        except Exception as e:
            print(f"Error scraping page {page}: {str(e)}")
            continue
    
    # Combine all results
    if all_jobs:
        final_df = pd.concat(all_jobs, ignore_index=True)
        final_df.to_csv('useme_jobs_detailed.csv', index=False, encoding='utf-8')
        print(f"Successfully scraped total of {len(final_df)} jobs from {len(all_jobs)} pages")
        return final_df
    
    return None

if __name__ == "__main__":
    # Scrape multiple pages with full job descriptions
    all_jobs = scrape_with_pagination(num_pages=5)