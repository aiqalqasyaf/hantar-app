<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $applications = [

            [
                'company' => 'Grab',
                'role' => 'Software Engineer',
                'status' => 'interview',
                'applied_at' => '2026-07-01',
                'job_description' => <<<EOT
Responsibilities:
- Design and develop scalable backend services supporting millions of users.
- Build and maintain RESTful APIs and internal microservices.
- Improve system reliability, latency, and performance.
- Participate in architecture discussions and code reviews.
- Develop distributed systems using modern engineering practices.

Requirements:
- 1-3 years of software engineering experience.
- Strong programming skills in Go, Java, Python, or similar languages.
- Experience with PostgreSQL, Redis, and message queues.
- Familiarity with Kubernetes, Docker, and cloud platforms.
- Knowledge of distributed systems and API design.
EOT
            ],

            [
                'company' => 'Shopee',
                'role' => 'Backend Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-05',
                'job_description' => <<<EOT
Responsibilities:
- Develop backend services for high-volume e-commerce systems.
- Design APIs used by mobile and web applications.
- Optimize database queries and application performance.
- Build reliable microservices architecture.
- Troubleshoot production issues.

Requirements:
- 2+ years backend development experience.
- Strong Java or Go programming skills.
- Experience with Spring Boot, MySQL, Redis, and Kafka.
- Understanding of distributed systems.
- Experience with CI/CD pipelines and cloud infrastructure.
EOT
            ],

            [
                'company' => 'AirAsia',
                'role' => 'Full Stack Developer',
                'status' => 'offer',
                'applied_at' => '2026-06-20',
                'job_description' => <<<EOT
Responsibilities:
- Develop customer-facing web applications.
- Build frontend interfaces using modern frameworks.
- Develop backend APIs and database integrations.
- Improve application usability and performance.

Requirements:
- 2+ years full stack development experience.
- Experience with React, Vue, TypeScript, and Node.js.
- Knowledge of REST APIs and GraphQL.
- Experience with AWS services including Lambda and S3.
- Understanding of frontend testing frameworks.
EOT
            ],

            [
                'company' => 'Petronas Digital',
                'role' => 'Software Developer',
                'status' => 'rejected',
                'applied_at' => '2026-06-15',
                'job_description' => <<<EOT
Responsibilities:
- Develop enterprise software solutions.
- Maintain internal business applications.
- Participate in software design and testing.
- Improve existing systems and workflows.

Requirements:
- 1-2 years software development experience.
- Knowledge of Java, C#, Python, or PHP.
- Experience with SQL databases.
- Understanding of enterprise application architecture.
- Familiarity with Azure cloud services is preferred.
EOT
            ],

            [
                'company' => 'Maybank',
                'role' => 'Backend Developer',
                'status' => 'interview',
                'applied_at' => '2026-07-08',
                'job_description' => <<<EOT
Responsibilities:
- Develop secure banking backend systems.
- Implement financial transaction APIs.
- Improve system security and reliability.
- Work with compliance and security teams.

Requirements:
- 3+ years backend development experience.
- Experience with Java Spring Boot.
- Knowledge of Oracle Database and SQL optimization.
- Understanding of authentication protocols including OAuth2 and JWT.
- Experience with secure API development.
EOT
            ],

            [
                'company' => 'TNG Digital',
                'role' => 'Frontend Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-03',
                'job_description' => <<<EOT
Responsibilities:
- Develop modern fintech user interfaces.
- Build reusable frontend components.
- Improve frontend performance.
- Collaborate with designers and backend engineers.

Requirements:
- 2-4 years frontend experience.
- Strong React.js and TypeScript skills.
- Experience with Next.js and GraphQL.
- Familiarity with frontend testing tools.
- Understanding of accessibility standards.
EOT
            ],

            [
                'company' => 'CelcomDigi',
                'role' => 'Cloud DevOps Engineer',
                'status' => 'interview',
                'applied_at' => '2026-07-12',
                'job_description' => <<<EOT
Responsibilities:
- Manage AWS cloud infrastructure.
- Build CI/CD automation pipelines.
- Deploy containerized applications.
- Monitor production systems.
- Improve system availability.

Requirements:
- 3+ years DevOps experience.
- Strong AWS knowledge.
- Experience with Kubernetes, Docker, and Terraform.
- Knowledge of Linux administration.
- Experience with monitoring tools such as Prometheus and Grafana.
EOT
            ],

            [
                'company' => 'Intel Malaysia',
                'role' => 'Embedded Software Engineer',
                'status' => 'rejected',
                'applied_at' => '2026-05-30',
                'job_description' => <<<EOT
Responsibilities:
- Develop firmware and embedded software.
- Debug hardware and software integration issues.
- Optimize low-level system performance.

Requirements:
- 2+ years embedded development experience.
- Strong C/C++ programming skills.
- Knowledge of Linux kernel and hardware communication.
- Experience with embedded systems and debugging tools.
EOT
            ],

            [
                'company' => 'Microsoft Malaysia',
                'role' => 'Software Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-10',
                'job_description' => <<<EOT
Responsibilities:
- Build large-scale cloud software solutions.
- Solve complex engineering problems.
- Design reliable distributed systems.
- Collaborate with global engineering teams.

Requirements:
- 3+ years software engineering experience.
- Strong algorithms and data structures knowledge.
- Experience with C#, Azure, and cloud architecture.
- Understanding of scalable system design.
EOT
            ],

            [
                'company' => 'Carsome',
                'role' => 'Backend Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-10',
                'job_description' => <<<EOT
Responsibilities:
- Develop marketplace backend services.
- Build APIs and microservices.
- Improve database performance.
- Implement caching and messaging solutions.

Requirements:
- 2+ years backend experience.
- Experience with Go, PHP, or Node.js.
- Knowledge of PostgreSQL, Redis, Kafka.
- Familiarity with Docker and Kubernetes.
EOT
            ],

            [
                'company' => 'ByteDance',
                'role' => 'Machine Learning Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-04',
                'job_description' => <<<EOT
Responsibilities:
- Develop machine learning models.
- Process large datasets.
- Deploy ML models into production systems.
- Improve model accuracy and performance.

Requirements:
- 2-4 years ML engineering experience.
- Strong Python skills.
- Experience with PyTorch, TensorFlow, and MLOps.
- Knowledge of NLP or computer vision.
- Experience deploying models using cloud platforms.
EOT
            ],

            [
                'company' => 'Huawei',
                'role' => 'Network Software Engineer',
                'status' => 'rejected',
                'applied_at' => '2026-06-22',
                'job_description' => <<<EOT
Responsibilities:
- Develop network management software.
- Optimize communication systems.
- Debug networking issues.

Requirements:
- 2+ years software engineering experience.
- Strong C++ and Linux knowledge.
- Understanding of TCP/IP networking.
- Experience with distributed systems.
EOT
            ],

            [
                'company' => 'Axiata',
                'role' => 'Data Engineer',
                'status' => 'interview',
                'applied_at' => '2026-07-09',
                'job_description' => <<<EOT
Responsibilities:
- Build data pipelines.
- Process large-scale datasets.
- Maintain analytics infrastructure.
- Improve data quality.

Requirements:
- 3+ years data engineering experience.
- Experience with Python and SQL.
- Knowledge of Apache Spark, Airflow, and Snowflake.
- Understanding of ETL pipelines.
EOT
            ],

            [
                'company' => 'Fusionex',
                'role' => 'AI Engineer',
                'status' => 'applied',
                'applied_at' => '2026-07-06',
                'job_description' => <<<EOT
Responsibilities:
- Develop AI solutions for business problems.
- Train and deploy machine learning models.
- Perform data analysis and experimentation.

Requirements:
- 1-3 years AI development experience.
- Python programming skills.
- Experience with TensorFlow, PyTorch.
- Knowledge of NLP and computer vision.
EOT
            ],

        ];

        foreach ($applications as $application) {
            Application::create([
                'user_id' => $user->id,
                ...$application,
            ]);
        }
    }
}